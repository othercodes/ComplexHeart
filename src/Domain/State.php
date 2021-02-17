<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain;

use OtherCode\ComplexHeart\Domain\Exceptions\StateException;
use OtherCode\ComplexHeart\Domain\ValueObjects\EnumValue;

/**
 * Class State
 *
 * @see https://en.wikipedia.org/wiki/State_pattern
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain
 */
abstract class State extends EnumValue
{
    private const DEFAULT = 'default';

    private string $defaultState;

    /**
     * Mapping of the available transitions with the transition function.
     *
     * @var array<string, callable|null>
     */
    private array $transitions = [];

    /**
     * State constructor.
     *
     * @param  string  $value
     */
    public function __construct(string $value = self::DEFAULT)
    {
        $this->configure();

        parent::__construct(
            $value === self::DEFAULT
                ? $this->defaultState
                : $value
        );
    }

    /**
     * Configure the state machine with the specific transitions.
     *
     * $this->defaultState('SOME_STATE')
     *  ->allowTransition('SOME_STATE', 'OTHER_STATE')
     *  ->allowTransition('SOME_STATE', 'ANOTHER_STATE');
     */
    abstract protected function configure(): void;

    /**
     * Set the default value for the state machine.
     *
     * @param  string  $state
     *
     * @return $this
     */
    protected function defaultState(string $state): State
    {
        $this->defaultState = $state;
        return $this;
    }

    /**
     * Define the allowed state transitions.
     *
     * @param  string  $from
     * @param  string  $to
     * @param  callable|null  $transition
     *
     * @return $this
     * @throws StateException
     */
    protected function allowTransition(string $from, string $to, ?callable $transition = null): State
    {
        if (!static::isValid($from)) {
            throw StateException::stateNotFound($from, static::getValues());
        }

        if (!static::isValid($to)) {
            throw StateException::stateNotFound($to, static::getValues());
        }

        if (is_null($transition)) {
            $key = $this->getTransitionKey($from, $to);
            if ($this->canCall($method = $this->getStringKey($key, 'from'))) {
                // compute method using the exactly transition key: fromOneToAnother
                $transition = [$this, $method];
            } elseif ($this->canCall($method = $this->getStringKey($to, 'to'))) {
                // compute the method using only the $to state: toAnother
                $transition = [$this, $method];
            }
        }

        $this->transitions[$this->getTransitionKey($from, $to)] = $transition;

        return $this;
    }

    /**
     * Set the value and executed the "on{State}" method if it's available.
     *
     * This method is automatically invoked from the HasAttributes trait
     * on set() the value property.
     *
     * @param  string  $value
     *
     * @return string
     */
    protected function setValueValue(string $value): string
    {
        $onSetStateMethod = $this->getStringKey($value, 'on');
        if ($this->canCall($onSetStateMethod)) {
            call_user_func_array([$this, $onSetStateMethod], []);
        }
        return $value;
    }

    /**
     * Compute the transition key using the $from and $to strings.
     *
     * @param  string  $from
     * @param  string  $to
     *
     * @return string
     */
    private function getTransitionKey(string $from, string $to): string
    {
        return $this->getStringKey("{$from}_to_{$to}");
    }

    /**
     * Check if the given $from $to transition is allowed.
     *
     * @param  string  $from
     * @param  string  $to
     *
     * @return bool
     */
    private function isTransitionAllowed(string $from, string $to): bool
    {
        return array_key_exists($this->getTransitionKey($from, $to), $this->transitions);
    }

    /**
     * Execute the transition $from oneState $to another.
     *
     * @param  string  $to
     * @param  mixed  ...$arguments
     *
     * @return $this
     * @throws StateException
     */
    public function transitionTo(string $to, ...$arguments): State
    {
        if (!static::isValid($to)) {
            throw StateException::stateNotFound($to, static::getValues());
        }

        if (!$this->isTransitionAllowed($this->value, $to)) {
            throw StateException::transitionNotAllowed($this->value, $to);
        }

        if ($transition = $this->transitions[$this->getTransitionKey($this->value, $to)]) {
            call_user_func_array($transition, $arguments);
        }

        $this->set('value', $to);

        return $this;
    }
}