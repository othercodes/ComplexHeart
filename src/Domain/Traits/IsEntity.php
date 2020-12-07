<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

/**
 * Trait IsEntity
 *
 * > Objects that have a distinct identity that runs through time and different representations.
 * > -- Martin Fowler
 *
 * @see https://martinfowler.com/bliki/EvansClassification.html
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait IsEntity
{
    use IsModel, HasIdentity, HasEquality {
        HasIdentity::hash insteadof HasEquality;
    }
}
