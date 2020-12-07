<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

/**
 * Trait HasEquality
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait HasEquality
{
    /**
     * Equality configuration.
     *
     * - algorithm: defines the algorithm used to hash the string
     * representation of the value object. sha256 by default.
     *
     * @var array<string, string>
     */
    private array $_equality = [
        'algorithm' => 'sha256',
    ];

    /**
     * Compare $this object with $other object. If the class is not
     * the same directly return false, compare value equality hash
     * otherwise.
     *
     * @param  object  $other
     *
     * @return bool
     */
    public function equals(object $other): bool
    {
        if (!($other instanceof static)) {
            return false;
        }

        return $this->hash() === $other->hash();
    }

    /**
     * Computes the equality hash using the configured algorithm.
     *
     * @return string
     */
    protected function hash(): string
    {
        return hash($this->_equality['algorithm'], $this->__toString());
    }
}
