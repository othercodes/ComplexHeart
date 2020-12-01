<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain;

use OtherCode\ComplexHeart\Domain\Traits\HasAttributes;
use OtherCode\ComplexHeart\Domain\Traits\HasEquality;
use OtherCode\ComplexHeart\Domain\Traits\HasInvariants;

/**
 * Trait IsValueObject
 *
 * > A small simple object, like money or a date range, whose equality isn't based on identity.
 * > -- Martin Fowler
 *
 * @see https://martinfowler.com/eaaCatalog/valueObject.html
 * @see https://martinfowler.com/bliki/ValueObject.html
 * @see https://martinfowler.com/bliki/EvansClassification.html
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain
 */
trait IsValueObject
{
    use HasEquality, HasInvariants, HasAttributes {
        attributes as private;
    }

    /**
     * Initialize the value object. Just as the constructor will do.
     *
     * @param  array  $source
     * @param  callable|null  $onFail
     */
    protected function initialize(array $source, callable $onFail = null): void
    {
        $this->hydrate($source);
        $this->check($onFail);
    }

    /**
     * Represents the object as String.
     *
     * @return string
     */
    abstract public function __toString(): string;
}
