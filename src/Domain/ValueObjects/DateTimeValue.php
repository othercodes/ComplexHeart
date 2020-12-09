<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\ValueObjects;

use DateTimeZone;
use Carbon\CarbonImmutable;
use Exception;
use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\HasEquality;

/**
 * Class DateTimeValue
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\ValueObjects
 */
class DateTimeValue extends CarbonImmutable implements ValueObject
{
    use HasEquality;

    /**
     * DateTimeValue constructor.
     *
     * @param  string|null  $time
     * @param  DateTimeZone|string|null  $tz
     *
     * @throws Exception
     */
    public function __construct($time = null, $tz = null)
    {
        parent::__construct($time, $tz);
        $this->settings(['toStringFormat' => 'c']);
    }

    /**
     * Return the value as string.
     *
     * @return string
     */
    protected function value(): string
    {
        return $this->toIso8601String();
    }

    /**
     * Return the attribute values.
     *
     * @return string[]
     */
    public function values(): array
    {
        return ['value' => $this->value()];
    }
}
