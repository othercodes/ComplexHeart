<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\ValueObjects;

use ReflectionClass;
use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\IsValueObject;

/**
 * Class EnumValue
 *
 * @method mixed value()
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\ValueObjects
 */
abstract class EnumValue implements ValueObject
{
    use IsValueObject;

    /**
     * The Enum value.
     *
     * @var mixed
     */
    private $value;

    /**
     * Internal cache.
     *
     * @var array
     */
    protected static array $cache = [];

    /**
     * EnumValue constructor.
     *
     * @param  mixed  $value
     */
    public function __construct($value)
    {
        $this->initialize(['value' => $value]);
    }

    /**
     * Check if the given value is in the list of allowed values.
     *
     * @return bool
     */
    protected function invariantValueMustBeOneOfAllowed(): bool
    {
        return static::isValid($this->value());
    }

    /**
     * Check if the given value is valid for the current enum.
     *
     * @param  mixed  $value
     *
     * @return bool
     */
    public static function isValid($value): bool
    {
        if (!isset(static::$cache[static::class])) {
            $reflection = new ReflectionClass(static::class);
            static::$cache[static::class] = $reflection->getConstants();
        }

        return in_array($value, static::$cache[static::class], true);
    }

    /**
     * Return the available labels.
     *
     * @return string[]
     */
    public static function getLabels(): array
    {
        return array_keys(static::$cache[static::class]);
    }

    /**
     * Return the available values.
     *
     * @return string[]
     */
    public static function getValues(): array
    {
        return array_values(static::$cache[static::class]);
    }

    /**
     * Return the string representation of the object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->value();
    }
}
