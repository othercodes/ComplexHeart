<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Contracts;

use OtherCode\ComplexHeart\Domain\Contracts\Bus\EventBus;

/**
 * Interface Aggregate
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Contracts
 */
interface Aggregate extends Entity
{
    /**
     * Publish the registered Domain Events.
     *
     *  $aggregate = new Aggregate();
     *  // do things and generate events
     *  $aggregate->publishDomainEvents($eventBus);
     *
     * @param  EventBus  $eventBus
     * @return void
     */
    public function publishDomainEvents(EventBus $eventBus): void;
}
