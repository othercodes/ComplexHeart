<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Application;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use OtherCode\ComplexHeart\Application\CriteriaBuilder;
use OtherCode\ComplexHeart\Domain\Criteria\Criteria;

/**
 * Class CriteriaBuilderTest
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Application
 */
class CriteriaBuilderTest extends MockeryTestCase
{
    public function testShouldBuildCriteriaInstance(): void
    {
        $criteria = (new CriteriaBuilder())->build();
        $this->assertInstanceOf(Criteria::class, $criteria);
    }

    public function testShouldAddFiltersToCriteria(): void
    {
        $criteria = (new CriteriaBuilder())
            ->filterEqual('name', 'Jules')
            ->filterNotEqual('surname', 'Wallace')
            ->filterGreaterThan('height', 1)
            ->filterLessThan('weight', 100)
            ->filterGreaterOrEqualThan('age', 18)
            ->filterLessOrEqualThan('age', 50)
            ->filterIn('address.state', ['FL', 'NY'])
            ->filterNotIn('address.zip', [10, 11, 12, 13])
            ->filterLike('job.title', '%Gangster%')
            ->filterIsNull('lastActivityDate')
            ->filterIsNotNull('lastLoginDate')
            ->build();

        $this->assertCount(11, $criteria->filters());
    }

    public function testShouldSetOrderByAndOrderType(): void
    {
        $criteria = (new CriteriaBuilder())
            ->orderedBy('name')
            ->orderedType('desc')
            ->build();

        $this->assertEquals('name', $criteria->orderBy());
        $this->assertEquals('desc', $criteria->orderType());
    }

    public function testShouldSetPageLimitAndPageOffset(): void
    {
        $criteria = (new CriteriaBuilder())
            ->withLimit(50)
            ->withOffset(100)
            ->build();

        $this->assertEquals(50, $criteria->pageLimit());
        $this->assertEquals(100, $criteria->pageOffset());
    }
}
