<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample\ValueObjects;

use OtherCode\ComplexHeart\Domain\ValueObjects\ArrayValue;

class ShoppingList extends ArrayValue
{
    protected int $_minItems = 1;

    protected string $valueType = 'string';
}