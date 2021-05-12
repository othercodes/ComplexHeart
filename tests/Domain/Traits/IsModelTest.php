<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\Traits;


use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\FullName;

/**
 * Class IsModelTest
 * @author Dmytro <dmytro@2amigos.us>
 * @package OtherCode\ComplexHeart\Tests\Domain\Traits
 */
class IsModelTest extends MockeryTestCase
{
    public function testModelCanCloneItselfWithOverrides(): void
    {
        $name = new FullName('John', 'Dow');
        $nameCopy = $name->withLastName('Smith');

        $this->assertEquals($name->firstName(), $nameCopy->firstName());
        $this->assertEquals('Smith', $nameCopy->lastName());
    }
}
