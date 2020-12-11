<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

/**
 * Trait IsAggregate
 *
 * > Aggregate is a cluster of domain objects that can be treated as a single unit.
 * > -- Martin Fowler
 *
 * @see https://martinfowler.com/bliki/DDD_Aggregate.html
 * @see https://martinfowler.com/bliki/EvansClassification.html
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait IsAggregate
{
    use IsEntity, HasDomainEvents, HasServiceBus;
}
