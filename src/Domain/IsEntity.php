<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain;

use OtherCode\ComplexHeart\Domain\Traits\HasAttributes;
use OtherCode\ComplexHeart\Domain\Traits\HasIdentity;
use OtherCode\ComplexHeart\Domain\Traits\HasInvariants;

/**
 * Trait IsEntity
 *
 * > Objects that have a distinct identity that runs through time and different representations.
 * > -- Martin Fowler
 *
 * @see https://martinfowler.com/bliki/EvansClassification.html
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain
 */
trait IsEntity
{
    use HasIdentity, HasAttributes, HasInvariants;

    /**
     * Initialize the Entity. Just as the constructor will do.
     *
     * @param  array  $source
     * @param  callable|null  $onFail
     */
    protected function initialize(array $source, callable $onFail = null): void
    {
        $this->hydrate($source);
        $this->check($onFail);
    }
}
