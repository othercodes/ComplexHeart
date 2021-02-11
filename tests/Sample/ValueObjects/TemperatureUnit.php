<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample\ValueObjects;

use OtherCode\ComplexHeart\Domain\ValueObjects\EnumValue;

/**
 * Class TemperatureUnit
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Sample\ValueObjects
 */
class TemperatureUnit extends EnumValue
{
    public const KELVIN = 'kelvin';
    public const FAHRENHEIT = 'fahrenheit';
    public const CELSIUS = 'celsius';
}