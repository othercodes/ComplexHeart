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
     * - prefix: defines the invariant string prefix: "invariant" by default.
     * - exception: Defines the exception that will be thrown on invariant violation.
     * - messages.*: messages used by this feature, can be customized by overriding the
     * property in the child class.
     *
     * @var array<string, string>
     */
    private array $_invariant = [
        'prefix'        => "invariant",
        'exception'     => InvariantViolation::class,
        'messages.fail' => "Unable to create {class} due: \n{violations}\n",
    ];

    /**
     * Retrieve the object invariants.
     *
     * @return string[]
     */
    final private function invariants(): array
    {
        return array_filter(
            get_class_methods($this),
            function (string $name) {
                return strpos($name, trim($this->_invariant['prefix'])) === 0;
            }
        );
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

        $parse = fn(string $invariant) => strtolower(
            preg_replace('/[A-Z]([A-Z](?![a-z]))*/', ' $0', $invariant)
        );

        foreach ($this->invariants() as $invariant) {
            try {
                if (!call_user_func_array([$this, $invariant], [])) {
                    $violations[$invariant] = $parse($invariant);
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
