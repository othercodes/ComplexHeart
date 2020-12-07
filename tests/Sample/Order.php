<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample;

use Exception;
use OtherCode\ComplexHeart\Domain\Contracts\Aggregate;
use OtherCode\ComplexHeart\Domain\Traits\IsAggregate;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue as OrderId;
use OtherCode\ComplexHeart\Tests\Sample\Events\OrderHasBeenCreated;

/**
 * Class Order
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Sample
 */
final class Order implements Aggregate
{
    use IsAggregate;

    private OrderId $id;

    private array $orderLines;

    /**
     * Order constructor.
     *
     * @param  OrderId  $id
     * @param  OrderLine  ...$orderLines
     */
    public function __construct(OrderId $id, OrderLine ...$orderLines)
    {
        $this->initialize(['id' => $id, 'orderLines' => $orderLines]);
    }

    /**
     * Named constructor.
     *
     * @param  OrderId  $id
     * @param  OrderLine  ...$orderLines
     *
     * @return static
     * @throws Exception
     */
    public static function create(OrderId $id, OrderLine ...$orderLines): self
    {
        $order = new self($id, ...$orderLines);
        $order->registerDomainEvent(new OrderHasBeenCreated($order->id()->value()));

        return $order;
    }

    /**
     * Get the domain events. Just Testing purposes.
     *
     * @return array
     */
    public function getDomainEvents(): array
    {
        return $this->_domainEvents;
    }
}
