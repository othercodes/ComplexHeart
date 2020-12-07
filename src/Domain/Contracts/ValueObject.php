<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Contracts;

/**
 * Interface ValueObject
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Contracts
 */
interface ValueObject
{
    /**
     * Return the attribute values.
     *
     * @return array
     */
    public function values(): array;

    /**
     * Compare $this object with $other object.
     *
     * @param  object  $other
     *
     * @return bool
     */
    public function equals(object $other): bool;
}
