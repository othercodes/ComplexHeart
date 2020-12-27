<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain;

use stdClass;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\Collection;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;

/**
 * Class CollectionTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain
 */
class CollectionTest extends MockeryTestCase
{
    public function testShouldSuccessfullyInstantiateACollection(): void
    {
        $c = new class (['foo', 'bar']) extends Collection {
            protected string $typeOf = 'string';
        };

        $this->assertInstanceOf(Collection::class, $c);
    }

    public function testShouldFailWithWrongPrimitiveValueItemTypes(): void
    {
        $this->expectException(InvariantViolation::class);

        new class ([1, '2']) extends Collection {
            protected string $typeOf = 'integer';
        };
    }

    public function testShouldFailWithWrongClassValueItemTypes(): void
    {
        $this->expectException(InvariantViolation::class);

        new class ([new stdClass(), '2']) extends Collection {
            protected string $typeOf = stdClass::class;
        };
    }

    public function testShouldFailDueToAmountOfItemsIsGreaterThanItemsPerPage(): void
    {
        $this->expectException(InvariantViolation::class);

        new Collection([0, 1, 2, 3, 4], 10, 2);
    }

    public function testShouldFailDueToAmountOfItemsIsGreaterThanTotalItems(): void
    {
        $this->expectException(InvariantViolation::class);

        new Collection([0, 1, 2, 3, 4], 2, 5);
    }
}
