<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\Traits;


use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue;
use OtherCode\ComplexHeart\Tests\Sample\Aggregates\User;

/**
 * Class IsAggregateTrait
 * @author Dmytro <dmytro@2amigos.us>
 * @package OtherCode\ComplexHeart\Tests\Domain\Traits
 */
class IsAggregateTraitTest extends MockeryTestCase
{
    public function testAggregateCanCloneItselfWithOverridesAndDomainEvents(): void
    {
        $user = new User(UUIDValue::random(), 'user@email.com', 'John Dow');
        $userCopy = $user->withEmail('new@email.com');

        $this->assertEquals($user->id(), $userCopy->id());
        $this->assertEquals('new@email.com', $userCopy->email());
        $this->assertEquals($user->name(), $userCopy->name());

        $this->assertEquals($user->getDomainEvents(), $userCopy->getDomainEvents());
    }
}
