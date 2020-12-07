<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample\ValueObjects;

use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
use OtherCode\ComplexHeart\Domain\ValueObjects\StringValue;

/**
 * Class ProductName
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\ValueObjects
 */
final class ProductName extends StringValue
{
    protected int $_maxLength = 30;

    protected int $_minLength = 3;

    protected function invariantMustStartWithStringProduct(): bool
    {
        if (strpos($this->value(), 'PR') !== 0) {
            throw new InvariantViolation('Product Name must start with PR chars');
        }

        return true;
    }
}
