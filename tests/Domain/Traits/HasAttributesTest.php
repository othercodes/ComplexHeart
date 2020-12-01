<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\Traits;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\ProductName;

/**
 * Class HasAttributesTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\Traits
 */
class HasAttributesTest extends MockeryTestCase
{
    public function testObjectHasValues(): void
    {
        $vo = new ProductName('PR some value');

        $this->assertEquals("PR some value", $vo->value());
        $this->assertArrayHasKey("value", $vo->values());
    }
}
