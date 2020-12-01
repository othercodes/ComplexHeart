<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\ValueObjects;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\Enabled;

/**
 * Class BooleanValueTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\ValueObjects
 */
class BooleanValueTest extends MockeryTestCase
{
    public function testShouldCreateValidValueObject(): void
    {
        $vo = new Enabled(true);
        $this->assertTrue($vo->value());
    }

    public function testShouldReturnTrueOnEqualObjects(): void
    {
        $vo = new Enabled(true);
        $this->assertTrue($vo->equals(new Enabled(true)));
    }

    public function testShouldReturnFalseOnNotEqualObjects(): void
    {
        $vo = new Enabled(true);
        $this->assertFalse($vo->equals(new Enabled(false)));
    }
}
