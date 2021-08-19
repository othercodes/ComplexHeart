<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\ValueObjects;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\ValueObjects\DateTimeValue;

/**
 * Class DateTimeValueTest
 * @author Dmytro <dmytro@2amigos.us>
 * @package OtherCode\ComplexHeart\Tests\Domain\ValueObjects
 */
class DateTimeValueTest extends MockeryTestCase
{
    public function testShouldInitializeStringFormatWhenWakesUp(): void
    {
        $instance = new DateTimeValue();
        $serialized = serialize($instance);
        $wakedUp = unserialize($serialized);
        $this->assertSame($instance->__toString(), $wakedUp->__toString());
    }
}
