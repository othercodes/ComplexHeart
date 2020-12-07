<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

use OtherCode\ComplexHeart\Domain\Bus\Event;

/**
 * Trait HasDomainEvents
 *
 * @see https://martinfowler.com/eaaDev/DomainEvent.html
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait HasDomainEvents
{
    /**
     * List of registered domain events.
     *
     * @var array<Event>
     */
    private array $_domainEvents = [];

    /**
     * Pull out all the registered domain events.
     *
     * @return array<Event>
     */
    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->_domainEvents;
        $this->_domainEvents = [];

        return $domainEvents;
    }

    /**
     * Register a new DomainEvent.
     *
     * @param  Event  $domainEvent
     */
    final protected function registerDomainEvent(Event $domainEvent): void
    {
        $this->_domainEvents[] = $domainEvent;
    }
}
