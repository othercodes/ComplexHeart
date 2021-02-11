<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\ValueObjects;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue;

/**
 * Class UUIDValueTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\ValueObjects
 */
class UUIDValueTest extends MockeryTestCase
{
    public function testShouldCreateValidValueObject(): void
    {
        $uuid = '32b10769-50a7-4141-bfb7-a08fc7045a19';

        $vo = new UUIDValue($uuid);
        $this->assertIsString($vo->value());
    }

    public function testShouldCreateValidRandomValueObject(): void
    {
        $vo = UUIDValue::random();
        $this->assertIsString($vo->value());
    }

    public function testShouldReturnTrueOnEqualObjects(): void
    {
        $uuid = '32b10769-50a7-4141-bfb7-a08fc7045a19';

        $vo = new UUIDValue($uuid);
        $this->assertTrue($vo->equals(new UUIDValue($uuid)));
        $this->assertTrue($vo->is(new UUIDValue($uuid)));
    }

    public function testShouldReturnFalseOnNotEqualObjects(): void
    {
        $uuid1 = '32b10769-50a7-4141-bfb7-a08fc7045a19';
        $uuid2 = '09d4396b-e5e1-43e7-acb8-ba1704128e15';

        $vo = new UUIDValue($uuid1);
        $this->assertFalse($vo->equals(new UUIDValue($uuid2)));
    }

    public function testShouldThrowExceptionOnInvalidValue(): void
    {
        $this->expectException(InvariantViolation::class);

        new UUIDValue('wrong');
    }
}
