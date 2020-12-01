<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\ValueObjects;

use OtherCode\ComplexHeart\Domain\IsValueObject;

/**
 * Class BooleanValue
 *
 * @method bool value()
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\ValueObjects
 */
abstract class BooleanValue
{
    use IsValueObject;

    /**
     * The string representation of the boolean value.
     *
     * @var array<string, string>
     */
    protected array $_strings = [
        'true'  => 'true',
        'false' => 'false',
    ];

    /**
     * The value storage.
     *
     * @var bool
     */
    private bool $value;

    /**
     * BoolValueObject constructor.
     *
     * @param  bool  $value
     */
    public function __construct(bool $value)
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
        return $this->value()
            ? $this->_strings['true']
            : $this->_strings['false'];
    }
}
