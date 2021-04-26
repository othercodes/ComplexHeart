<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Domain\Criteria;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Domain\Criteria\Criteria;
use OtherCode\ComplexHeart\Domain\Criteria\FilterGroup;
use OtherCode\ComplexHeart\Domain\Criteria\Order;
use OtherCode\ComplexHeart\Domain\Criteria\Page;

/**
 * Class CriteriaTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Domain\Criteria
 */
class CriteriaTest extends MockeryTestCase
{
    public function testShouldBuildCriteriaSuccessfully(): void
    {
        $criteria = new Criteria(
            FilterGroup::create(
                [
                    ['name', 'in', ['Marsellus', 'Mia']],
                    ['surname', '=', 'Wallace'],
                ]
            ),
            Order::create('name'),
            Page::create(100, 100)
        );

        $this->assertCount(2, $criteria->filters());
        $this->assertCount(2, $criteria->filters()->filters());

        $this->assertInstanceOf(Order::class, $criteria->order());
        $this->assertEquals('name', $criteria->orderBy());
        $this->assertEquals('asc', $criteria->orderType());
        $this->assertFalse($criteria->order()->isNone());

        $this->assertInstanceOf(Page::class, $criteria->page());
        $this->assertEquals(100, $criteria->pageLimit());
        $this->assertEquals(100, $criteria->pageOffset());

        $this->assertEquals(
            "name.in.Marsellus|Mia+surname.=.Wallace#name.asc#100.100",
            (string)$criteria
        );
    }
}