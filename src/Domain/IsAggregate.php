<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain;

use OtherCode\ComplexHeart\Domain\Traits\HasDomainEvents;

/**
 * Trait IsAggregate
 *
 * > Aggregate is a cluster of domain objects that can be treated as a single unit.
 * > -- Martin Fowler
 *
 * @see https://martinfowler.com/bliki/DDD_Aggregate.html
 * @see https://martinfowler.com/bliki/EvansClassification.html
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain
 */
trait IsAggregate
{
    use IsEntity, HasDomainEvents;

    /**
     * Initialize the Aggregate. Just as the constructor will do.
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
