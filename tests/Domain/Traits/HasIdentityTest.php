<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\Traits;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue;
use OtherCode\ComplexHeart\Tests\Sample\OrderLine;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\ProductName;

/**
 * Class HasIdentityTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\Traits
 */
class HasIdentityTest extends MockeryTestCase
{
    public function testShouldValidateIdField(): void
    {
        $this->assertInstanceOf(
            OrderLine::class,
            new OrderLine(UUIDValue::random(), new ProductName('PR some value'))
        );
    }

    public function testShouldAccessIdField(): void
    {
        $e = new OrderLine(UUIDValue::random(), new ProductName('PR some value'));
        $this->assertInstanceOf(UUIDValue::class, $e->id());
    }

    public function testShouldCompareUsingIdInsteadValue(): void
    {
        $id = UUIDValue::random();

        $a = new OrderLine($id, new ProductName('PR some value'));
        $b = new OrderLine($id, new ProductName('PR some value'));

        $this->assertTrue($a->equals($b));
    }
}
