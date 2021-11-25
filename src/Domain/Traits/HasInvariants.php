<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

use Exception;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;

use function Lambdish\Phunctional\filter;


/**
 * Trait HasInvariants
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait HasInvariants
{
    /**
     * Static property to keep cached invariants list to optimize performance.
     * @var array<string, <string, mixed>>
     */
    private static $_invariantsCache = [];

    /**
     * Invariant configuration.
     *
     * - exception: Defines the exception that will be thrown on invariant violation.
     * - messages.*: messages used by this feature, can be customized by overriding the
     * property in the child class.
     *
     * @var array<string, string>
     */
    private array $_invariant = [
        'exception' => InvariantViolation::class,
        'handler' => 'invariantHandler',
        'messages.fail' => "Unable to create {class} due: {violations}",
    ];

    /**
     * Retrieve the object invariants.
     *
     * @return string[]
     */
    final public static function invariants(): array
    {
        if (empty(static::$_invariantsCache[static::class])) {
            $invariants = [];

            foreach (get_class_methods(static::class) as $invariant) {
                if (strpos($invariant, 'invariant') === 0 && $invariant !== 'invariants') {
                    $invariants[$invariant] = str_replace(
                        'invariant ',
                        '',
                        strtolower(
                            preg_replace('/[A-Z]([A-Z](?![a-z]))*/', ' $0', $invariant)
                        )
                    );
                }
            }

            static::$_invariantsCache[static::class] = $invariants;
        }

        return static::$_invariantsCache[static::class];
    }

    /**
     * Execute all the registered invariants.
     *
     *  - All invariants method names must begin with the invariant prefix
     *    ("invariant" by default) and must be written in PascalCase.
     *  - All invariant can either return bool or throw an exception.
     *  - Return true by invariant means the invariants is passed successfully.
     *  - Return false by the invariant means the invariant has failed.
     *
     * If boolean is returned the error message will be the invariant method name
     * (PascalCase) in normal case.
     *
     * If exception is thrown the error message will be the exception message.
     *
     * $onFail function must have following signature:
     *  fn(array<string, string>) => void
     *
     * @param  callable|null  $filter
     * @param  callable|null  $onFail
     *
     * @return void
     */
    final private function check(callable $filter = null, callable $onFail = null): void
    {
        $violations = [];

        $invariants = filter(
            is_null($filter)
                ? fn(string $rule, string $invariant): bool => true
                : $filter,
            static::invariants()
        );

        foreach ($invariants as $invariant => $rule) {
            try {
                if (!call_user_func_array([$this, $invariant], [])) {
                    $violations[$invariant] = $rule;
                }
            } catch (Exception $e) {
                $violations[$invariant] = $e->getMessage();
            }
        }

        if (count($violations) > 0) {
            if (is_null($onFail)) {
                $onFail = (method_exists($this, $this->_invariant['handler']))
                    ? function (array $violations): void {
                        call_user_func_array([$this, $this->_invariant['handler']], [$violations]);
                    }
                    : function (array $violations): void {
                        throw new $this->_invariant['exception'](
                            strtr(
                                $this->_invariant['messages.fail'],
                                [
                                    '{class}' => basename(str_replace('\\', '/', static::class)),
                                    '{violations}' => implode(",", $violations),
                                ]
                            )
                        );
                    };
            }

            $onFail($violations);
        }
    }
}
