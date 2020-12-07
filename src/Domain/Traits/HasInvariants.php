<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

use Exception;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;

/**
 * Trait HasInvariants
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait HasInvariants
{
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
        'exception'     => InvariantViolation::class,
        'messages.fail' => "Unable to create {class} due: \n{violations}\n",
    ];

    /**
     * Retrieve the object invariants.
     *
     * @return string[]
     */
    final public static function invariants(): array
    {
        $invariants = [];
        foreach (get_class_methods(static::class) as $invariant) {
            if (strpos($invariant, 'invariant') === 0) {
                $invariants[$invariant] = strtolower(
                    preg_replace('/[A-Z]([A-Z](?![a-z]))*/', ' $0', $invariant)
                );
            }
        }

        return $invariants;
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
     * @param  callable|null  $onFail
     *
     * @return void
     */
    final private function check(callable $onFail = null): void
    {
        $violations = [];

        foreach (static::invariants() as $invariant => $rule) {
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
                $onFail = function (array $violations): void {
                    throw new $this->_invariant['exception'](
                        strtr(
                            $this->_invariant['messages.fail'],
                            [
                                '{class}'      => basename(str_replace('\\', '/', static::class)),
                                '{violations}' => implode("\n", $violations),
                            ]
                        )
                    );
                };
            }

            $onFail($violations);
        }
    }
}
