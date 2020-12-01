<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample;

use OtherCode\ComplexHeart\Domain\IsAggregate;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue as OrderId;
use OtherCode\ComplexHeart\Tests\Sample\Events\OrderHasBeenCreated;

final class Order
{
    use IsAggregate;

    private OrderId $id;

    private array $orderLines;

    public function __construct(OrderId $id, OrderLine ...$orderLines)
    {
        $this->initialize(['id' => $id, 'orderLines' => $orderLines]);
    }

    public static function create(OrderId $id, OrderLine ...$orderLines): self
    {
        $order = new self($id, ...$orderLines);
        $order->register(new OrderHasBeenCreated($order->id()->value()));

        return $order;
    }

    public function getDomainEvents(): array
    {
        return $this->domainEvents;
    }
}
