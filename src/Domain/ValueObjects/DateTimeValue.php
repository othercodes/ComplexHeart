<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\ValueObjects;

use Carbon\CarbonImmutable;

/**
 * Class DateTimeValue
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\ValueObjects
 */
class DateTimeValue extends CarbonImmutable
{
    /**
     * Return the value as string.
     *
     * @return string
     */
    protected function value(): string
    {
        return $this->toIso8601String();
    }
}
