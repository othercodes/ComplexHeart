<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\Exceptions\StateNotFound;
use OtherCode\ComplexHeart\Domain\Exceptions\TransitionNotAllowed;
use OtherCode\ComplexHeart\Domain\State;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\PaymentStatus;

/**
 * Class StateTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain
 */
class StateTest extends MockeryTestCase
{
    public function testShouldCreateValidStateObject(): void
    {
        $state = new PaymentStatus();
        $this->assertEquals(PaymentStatus::PENDING, $state->value());
        $this->assertEquals('gray', $state->color());
    }

    public function testShouldTransitionedToValidStateAndExecuteSharedTransition(): void
    {
        $state = new PaymentStatus();
        $state->transitionTo(PaymentStatus::PAID);

        $this->assertEquals(PaymentStatus::PAID, $state->value());
        $this->assertEquals('green', $state->color());
        $this->assertEquals(1, $state->changes());
    }

    public function testShouldTransitionedToValidStateAndExecuteSpecificTransition(): void
    {
        $state = new PaymentStatus();
        $state->transitionTo(PaymentStatus::CANCELLED);

        $this->assertEquals(PaymentStatus::CANCELLED, $state->value());
        $this->assertEquals('red', $state->color());
        $this->assertEquals(1, $state->changes());
    }

    public function testShouldThrowExceptionTransitionNotAllowed(): void
    {
        $this->expectException(TransitionNotAllowed::class);

        $state = new PaymentStatus(PaymentStatus::CANCELLED);
        $state->transitionTo(PaymentStatus::PAID);
    }

    public function testShouldThrowExceptionStateNotFound(): void
    {
        $this->expectException(StateNotFound::class);

        $state = new PaymentStatus(PaymentStatus::CANCELLED);
        $state->transitionTo('NOT_VALID_STATE');
    }

    public function testShouldThrowExceptionStateNotFoundOnDefiningTransitionsFrom(): void
    {
        $this->expectException(StateNotFound::class);

        new class () extends State {
            public const ON = 'on';
            public const OFF = 'off';
            protected function configure(): void
            {
                $this->allowTransition('INVALID', self::OFF);
            }
        };
    }

    public function testShouldThrowExceptionStateNotFoundOnDefiningTransitionsTo(): void
    {
        $this->expectException(StateNotFound::class);

        new class () extends State {
            public const ON = 'on';
            public const OFF = 'off';
            protected function configure(): void
            {
                $this->allowTransition(self::ON, 'INVALID');
            }
        };
    }
}
