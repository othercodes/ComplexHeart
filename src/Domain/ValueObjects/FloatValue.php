<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\ValueObjects;

/**
 * Class FloatValue
 *
 * @method float value()
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\ValueObjects
 */
abstract class FloatValue extends Value
{
    /**
     * The value storage.
     *
     * @var float
     */
    protected float $value;

    /**
     * FloatValue constructor.
     *
     * @param  float  $value
     */
    public function __construct(float $value)
    {
        $this->initialize(['value' => $value]);
    }

    /**
     * To string value.
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->value();
    }
}