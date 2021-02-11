<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\ValueObjects;

use Mockery\Adapter\Phpunit\MockeryTestCase;

use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\Temperature;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\TemperatureUnit;

/**
 * Class FloatValueTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\ValueObjects
 */
class FloatValueTest extends MockeryTestCase
{
    public function testShouldCreateValidValueObject(): void
    {
        $vo = new Temperature(22.0, TemperatureUnit::CELSIUS);
        $this->assertEquals(22.0, $vo->value());
        $this->assertEquals('celsius', $vo->unit());
    }

    public function testShouldReturnTrueOnEqualObjects(): void
    {
        $vo = new Temperature(22.0, TemperatureUnit::CELSIUS);
        $this->assertTrue($vo->equals(new Temperature(22.0, TemperatureUnit::CELSIUS)));
    }

    public function testShouldReturnFalseOnNotEqualObjects(): void
    {
        $vo = new Temperature(22.0, TemperatureUnit::CELSIUS);
        $this->assertFalse($vo->equals(new Temperature(21.0, TemperatureUnit::CELSIUS)));
    }
}