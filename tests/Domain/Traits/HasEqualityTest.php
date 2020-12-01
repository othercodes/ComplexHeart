<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\Traits;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\ProductName;
use stdClass;

/**
 * Class HasEqualityTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\Traits
 */
class HasEqualityTest extends MockeryTestCase
{
    public function testShouldReturnTrueOnEqualObjects(): void
    {
        $vo = new ProductName('PR some value');

        $this->assertTrue($vo->equals(new ProductName('PR some value')));
    }

    public function testShouldReturnFalseOnNonEqualObjects(): void
    {
        $vo = new ProductName('PR some value');
        $this->assertFalse($vo->equals(new ProductName('PR different')));
        $this->assertFalse($vo->equals(new stdClass()));
    }
}
