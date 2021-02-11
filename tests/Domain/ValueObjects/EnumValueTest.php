<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\ValueObjects;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\TemperatureUnit;

/**
 * Class EnumValueTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\ValueObjects
 */
class EnumValueTest extends MockeryTestCase
{
    public function testShouldCreateValidValueObject(): void
    {
        $vo = new TemperatureUnit('celsius');
        $this->assertEquals('celsius', $vo->value());
        $this->assertCount(3, TemperatureUnit::getLabels());
    }

    public function testShouldReturnTrueOnEqualObjects(): void
    {
        $vo = new TemperatureUnit('celsius');
        $this->assertEquals('celsius', $vo->value());
    }

    public function testShouldReturnFalseOnNotEqualObjects(): void
    {
        $vo = new TemperatureUnit('celsius');
        $this->assertEquals('celsius', $vo->value());
    }
}