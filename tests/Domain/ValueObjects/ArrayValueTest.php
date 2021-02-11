<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\ValueObjects;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\Exceptions\ImmutableException;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\ShoppingList;

/**
 * Class ArrayValueTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\ValueObjects
 */
class ArrayValueTest extends MockeryTestCase
{
    public function testShouldCreateValidValueObject(): void
    {
        $vo = new ShoppingList(['Milk']);
        $this->assertCount(1, $vo);
        $this->assertTrue(isset($vo[0]));
        $this->assertEquals('Milk', $vo[0]);
    }

    public function testShouldThrowExceptionOnModificationAttempt(): void
    {
        $this->expectException(ImmutableException::class);

        $vo = new ShoppingList(['Milk']);
        $vo[] = 'Eggs';
    }

    public function testShouldThrowExceptionOnUnsetAttempt(): void
    {
        $this->expectException(ImmutableException::class);

        $vo = new ShoppingList(['Milk']);
        unset($vo[0]);
    }

    public function testShouldReturnTrueOnEqualObjects(): void
    {
        $a = new ShoppingList(['Milk']);
        $b = new ShoppingList(['Milk']);

        $this->assertTrue($a->equals($b));
    }

    public function testShouldReturnFalseOnNotEqualObjects(): void
    {
        $a = new ShoppingList(['Milk']);
        $b = new ShoppingList(['Eggs']);

        $this->assertFalse($a->equals($b));
    }

    public function testShouldIterateOverEachItem(): void
    {
        $vo = new ShoppingList(['Milk', 'Eggs', 'Yogurt']);
        foreach ($vo as $item) {
            $this->assertIsString($item);
        }
    }
}