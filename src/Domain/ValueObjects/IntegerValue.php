<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\ValueObjects;

use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
use OtherCode\ComplexHeart\Domain\IsValueObject;

/**
 * Class IntegerValue
 *
 * @method int value()
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\ValueObjects
 */
abstract class IntegerValue
{
    use IsValueObject;

    /**
     * Define the max value of the integer.
     *
     * @var int
     */
    protected int $_maxValue = PHP_INT_MAX;

    /**
     * Define the min value of the integer.
     *
     * @var int
     */
    protected int $_minValue = PHP_INT_MIN;

    /**
     * The value storage.
     *
     * @var int
     */
    private int $value;

    /**
     * IntegerValue constructor.
     *
     * @param  int  $value
     */
    public function __construct(int $value)
    {
        $this->initialize(['value' => $value]);
    }

    protected function invariantValueMinLengthMustBeValid(): bool
    {
        if ($this->value < $this->_minValue) {
            throw new InvariantViolation(
                "Min value {$this->_minValue} is required, given {$this->value}"
            );
        }

        return true;
    }

    protected function invariantValueMaxLengthMustBeValid(): bool
    {
        if ($this->value > $this->_maxValue) {
            throw new InvariantViolation(
                "Max length {$this->_maxValue} exceeded, given {$this->value}"
            );
        }

        return true;
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
