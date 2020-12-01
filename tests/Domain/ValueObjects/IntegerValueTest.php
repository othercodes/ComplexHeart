<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\ValueObjects;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\Amount;

/**
 * Class IntegerValueTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\ValueObjects
 */
class IntegerValueTest extends MockeryTestCase
{
    public function testShouldCreateValidValueObject(): void
    {
        $vo = new Amount(42);
        $this->assertEquals(42, $vo->value());
    }

    public function testShouldReturnTrueOnEqualObjects(): void
    {
        $vo = new Amount(42);
        $this->assertTrue($vo->equals(new Amount(42)));
    }

    public function testShouldReturnFalseOnNotEqualObjects(): void
    {
        $vo = new Amount(42);
        $this->assertFalse($vo->equals(new Amount(24)));
    }

    public function testShouldFailOnMinValueNotValue(): void
    {
        $this->expectException(InvariantViolation::class);
        new Amount(0);
    }

    public function testShouldFailOnMaxValueNotValue(): void
    {
        $this->expectException(InvariantViolation::class);
        new Amount(999999);
    }
}
