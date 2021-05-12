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
    use HasDomainEvents, HasServiceBus, IsEntity {
        withOverrides as entityWithOverrides;
    }

    /**
     * Makes a full copy of the instance with all registered domain events and overrides attributes provided by the client
     * @param  array  $overrides
     * @return static
     */
    protected function withOverrides(array $overrides)
    {
        $copy = $this->entityWithOverrides($overrides);

        foreach ($this->_domainEvents as $event) {
            $copy->registerDomainEvent($event);
        }

        return $copy;
    }
}
