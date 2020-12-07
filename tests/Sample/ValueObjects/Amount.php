<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample\ValueObjects;

use OtherCode\ComplexHeart\Domain\ValueObjects\IntegerValue;

/**
 * Class Amount
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Sample\ValueObjects
 */
final class Amount extends IntegerValue
{
    protected int $_minValue = 1;

    protected int $_maxValue = 100;
}
