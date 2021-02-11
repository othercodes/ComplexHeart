<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample\ValueObjects;

use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
use OtherCode\ComplexHeart\Domain\ValueObjects\FloatValue;

/**
 * Class Temperature
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Sample\ValueObjects
 */
final class Temperature extends FloatValue
{
    protected TemperatureUnit $unit;

    /**
     * Temperature constructor.
     *
     * @param  float  $value
     * @param  string  $unit
     */
    public function __construct(float $value = 0.0, string $unit = TemperatureUnit::CELSIUS)
    {
        $this->initialize(['unit' => new TemperatureUnit($unit)]);

        parent::__construct($value);
    }

    public static function units(): array
    {
        return [
            TemperatureUnit::KELVIN,
            TemperatureUnit::FAHRENHEIT,
            TemperatureUnit::CELSIUS
        ];
    }

    public function unit(): string
    {
        return $this->unit->value();
    }

    public function toCelsius(): self
    {
        switch ($this->unit) {
            case TemperatureUnit::KELVIN:
                return new self($this->value - 273.15, TemperatureUnit::CELSIUS);
            case TemperatureUnit::FAHRENHEIT:
                return new self(($this->value - 32) * 5 / 9, TemperatureUnit::CELSIUS);
            default:
                return $this;
        }
    }

    public function toFahrenheit(): self
    {
        if (TemperatureUnit::FAHRENHEIT === $this->unit) {
            return $this;
        }

        return new self(($this->toCelsius()->value * 9 / 5) + 32, TemperatureUnit::FAHRENHEIT);
    }

    public function ToKelvin(): self
    {
        if (TemperatureUnit::KELVIN === $this->unit) {
            return $this;
        }

        return new self($this->toCelsius() + 273.15, TemperatureUnit::KELVIN);
    }

    public function isGreaterThan(Temperature $temperature): bool
    {
        return $this->toCelsius()->value > $temperature->toCelsius()->value;
    }

    public function isLessThan(Temperature $temperature): bool
    {
        return $this->toCelsius()->value < $temperature->toCelsius()->value;
    }

    public function __toString(): string
    {
        return sprintf("%s %s", parent::__toString(), $this->unit);
    }
}