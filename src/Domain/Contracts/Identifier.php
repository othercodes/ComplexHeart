<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Contracts;

/**
 * Interface Identifier
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Contracts
 */
interface Identifier
{
    /**
     * Return the id value.
     *  $id->value() // "7a79bffb-4b4e-4d82-932e-c1524723622b"
     *  $id->value() // "459"
     *
     * @return string
     */
    public function value(): string;

    /**
     * Check if the given identifier is the same than the current one.
     *
     * @param  Identifier  $other
     *
     * @return bool
     */
    public function is(Identifier $other): bool;

    /**
     * Represents the id as string.
     *
     * @return string
     */
    public function __toString(): string;
}
