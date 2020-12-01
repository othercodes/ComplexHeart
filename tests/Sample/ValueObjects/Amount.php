<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample\ValueObjects;

use OtherCode\ComplexHeart\Domain\ValueObjects\IntegerValue;

final class Amount extends IntegerValue
{
    protected int $_minValue = 1;

    protected int $_maxValue = 100;
}
