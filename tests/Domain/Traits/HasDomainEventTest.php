<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\Traits;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue;
use OtherCode\ComplexHeart\Tests\Sample\Order;
use OtherCode\ComplexHeart\Tests\Sample\OrderLine;
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
        $o = Order::create(
            UUIDValue::random(),
            new OrderLine(UUIDValue::random(), new ProductName('PR 1')),
            new OrderLine(UUIDValue::random(), new ProductName('PR 2')),
        );

        $this->assertCount(1, $o->getDomainEvents());
        $this->assertCount(1, $o->pullDomainEvents());
        $this->assertCount(0, $o->getDomainEvents());
    }
}
