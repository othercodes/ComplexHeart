<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\Traits;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\Bus\Event;
use OtherCode\ComplexHeart\Domain\Contracts\Bus\EventBus;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue;
use OtherCode\ComplexHeart\Tests\Sample\Order;
use OtherCode\ComplexHeart\Tests\Sample\OrderLine;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\PaymentStatus;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\ProductName;

/**
 * Class HasDomainEventTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\Traits
 */
class HasDomainEventTest extends MockeryTestCase
{
    public function testShouldAddAndPullDomainEvent(): void
    {
        $eventBus = Mockery::mock(EventBus::class);
        $eventBus->shouldReceive('publish')
            ->once()
            ->with(Mockery::type(Event::class));

        $o = new Order(
            UUIDValue::random(),
            new PaymentStatus(PaymentStatus::PENDING),
            [
                new OrderLine(UUIDValue::random(), new ProductName('PR 1')),
                new OrderLine(UUIDValue::random(), new ProductName('PR 2'))
            ]
        );

        $this->assertCount(1, $o->getDomainEvents());
        $o->publishDomainEvents($eventBus);
        $this->assertCount(0, $o->getDomainEvents());
    }

    public function testShouldNotAddDomainEvent(): void
    {
        $eventBus = Mockery::mock(EventBus::class);
        $eventBus->shouldReceive('publish')->with(...[]);

        $o = Order::wakeup(
            UUIDValue::random(),
            new PaymentStatus(PaymentStatus::PENDING),
            [
                new OrderLine(UUIDValue::random(), new ProductName('PR 1')),
                new OrderLine(UUIDValue::random(), new ProductName('PR 2'))
            ]
        );

        $this->assertCount(0, $o->getDomainEvents());
        $o->publishDomainEvents($eventBus);
        $this->assertCount(0, $o->getDomainEvents());
    }
}
