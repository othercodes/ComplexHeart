<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample\ValueObjects;

use OtherCode\ComplexHeart\Domain\State;

/**
 * Class PaymentStatus
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Sample\ValueObjects
 */
class PaymentStatus extends State
{
    public const PENDING = 'pending';
    public const PAID = 'paid';
    public const CANCELLED = 'cancelled';

    private string $color;

    private int $stateChanges = 0;

    protected function configure(): void
    {
        $this->defaultState(self::PENDING)
            ->allowTransition(self::PENDING, self::PAID)
            ->allowTransition(self::PENDING, self::CANCELLED);
    }

    public function color(): string
    {
        return $this->color;
    }

    public function changes(): int
    {
        return $this->stateChanges;
    }

    protected function toPaid(): void
    {
        $this->stateChanges++;
    }

    protected function onPending(): void
    {
        $this->color = 'gray';
    }

    protected function onPaid(): void
    {
        $this->color = 'green';
    }

    protected function fromPendingToCancelled(): void
    {
        $this->stateChanges++;
    }

    protected function onCancelled(): void
    {
        $this->color = 'red';
    }
}