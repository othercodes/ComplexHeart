<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample;

use Exception;
use OtherCode\ComplexHeart\Domain\Contracts\Aggregate;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
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
     *
     * @throws Exception
     */
    public function __construct(OrderId $id, PaymentStatus $status, array $orderLines)
    {
        $this->initialize([$id, $status, $orderLines]);
        $this->registerDomainEvent(new OrderHasBeenCreated($this->id()->value()));
    }

    /**
     * Invariant, check that all items in order line array are type of OrderLine.
     *
     * @return bool
     * @throws InvariantViolation
     */
    protected function invariantEachOrderLineMustBeTypeOfOrderLine(): bool
    {
        foreach ($this->orderLines as $orderLine) {
            if (!($orderLine instanceof OrderLine)) {
                throw new InvariantViolation("All order lines must be type of OrderLine");
            }
        }

        return true;
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
    public static function create(OrderId $id, PaymentStatus $status, array $orderLines): self
    {
        return new self($id, $status, $orderLines);
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
