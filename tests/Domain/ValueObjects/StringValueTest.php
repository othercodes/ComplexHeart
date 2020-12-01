<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\ValueObjects;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
use OtherCode\ComplexHeart\Domain\ValueObjects\StringValue;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\ProductName;

/**
 * Class StringValueTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\ValueObjects
 */
class StringValueTest extends MockeryTestCase
{
    public function testShouldCreateValidValueObject(): void
    {
        $vo = new ProductName('PR sample');
        $this->assertEquals('PR sample', $vo->value());
        $this->assertEquals('PR sample', (string)$vo);
    }

    public function testShouldReturnTrueOnEqualObjects(): void
    {
        $vo = new ProductName('PR sample');
        $this->assertTrue($vo->equals(new ProductName('PR sample')));
    }

    public function testShouldReturnFalseOnNotEqualObjects(): void
    {
        $vo = new ProductName('PR sample');
        $this->assertFalse($vo->equals(new ProductName('PR diff')));
    }

    public function testShouldThrowExceptionOnMinLengthViolation(): void
    {
        $this->expectException(InvariantViolation::class);

        new class('a') extends StringValue {
            protected int $_minLength = 5;
        };
    }

    public function testShouldThrowExceptionOnMaxLengthViolation(): void
    {
        $this->expectException(InvariantViolation::class);

        new class('this is long') extends StringValue {
            protected int $_maxLength = 5;
        };
    }

    public function testShouldThrowExceptionOnRegexViolation(): void
    {
        $this->expectException(InvariantViolation::class);

        new class('INVALID') extends StringValue {
            protected string $_pattern = '[a-z]';
        };
    }
}
