<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample;

use Exception;
use OtherCode\ComplexHeart\Domain\Contracts\Aggregate;
use OtherCode\ComplexHeart\Domain\Traits\IsAggregate;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue as OrderId;
use OtherCode\ComplexHeart\Tests\Sample\Events\OrderHasBeenCreated;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\PaymentStatus;

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

    private PaymentStatus $status;

    private array $orderLines;

    /**
     * Order constructor.
     *
     * @param  OrderId  $id
     * @param  PaymentStatus  $status
     * @param  OrderLine  ...$orderLines
     */
    public function __construct(OrderId $id, PaymentStatus $status, OrderLine ...$orderLines)
    {
        $this->initialize(['id' => $id, 'status' => $status, 'orderLines' => $orderLines]);
    }

    /**
     * Named constructor.
     *
     * @param  OrderId  $id
     * @param  PaymentStatus  $status
     * @param  OrderLine  ...$orderLines
     *
     * @return static
     * @throws Exception
     */
    public static function create(OrderId $id, PaymentStatus $status, OrderLine ...$orderLines): self
    {
        $order = new self($id, $status, ...$orderLines);

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
