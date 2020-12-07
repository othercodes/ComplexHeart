<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

use OtherCode\ComplexHeart\Domain\Contracts\Bus\CommandBus;
use OtherCode\ComplexHeart\Domain\Contracts\Bus\EventBus;
use OtherCode\ComplexHeart\Domain\Contracts\Bus\QueryBus;
use OtherCode\ComplexHeart\Domain\Contracts\Bus\ServiceBus;

/**
 * Trait HasServiceBus
 *
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait HasServiceBus
{
    /**
     * The Service Bus instance.
     *
     * @var ServiceBus
     */
    private ServiceBus $_serviceBus;

    /**
     * Bind the given Service Bus to the current object.
     *
     * @param  ServiceBus  $bus
     */
    final public function bind(ServiceBus $bus): void
    {
        $this->_serviceBus = $bus;
    }

    /**
     * Return the Command Bus implementation.
     *
     * @return CommandBus
     */
    final protected function commandBus(): CommandBus
    {
        return $this->_serviceBus->commandBus();
    }

    /**
     * Return the Query Bus implementation.
     *
     * @return QueryBus
     */
    final protected function queryBus(): QueryBus
    {
        return $this->_serviceBus->queryBus();
    }

    /**
     * Return the Event bus implementation.
     *
     * @return EventBus
     */
    final protected function eventBus(): EventBus
    {
        return $this->_serviceBus->eventBus();
    }
}
