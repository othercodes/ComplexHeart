<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\Traits;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\ProductName;

/**
 * Class HasInvariantsTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\Traits
 */
class HasInvariantsTest extends MockeryTestCase
{
    public function testShouldExecuteSuccessfullyInvariants(): void
    {
        $vo = new ProductName('PR some-value');
        $this->assertEquals('PR some-value', $vo->value());
    }

    public function testShouldThrowExceptionWithDefaultMessage(): void
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('Max length 30 exceeded, given 51');

        new ProductName('PR-some-value-too-looooooooooooooooooong-for-the-vo');
    }

    public function testShouldThrowExceptionWithCustomMessage(): void
    {
        $this->expectException(InvariantViolation::class);
        $this->expectExceptionMessage('Product Name must start with PR chars');

        new ProductName('');
    }
}
