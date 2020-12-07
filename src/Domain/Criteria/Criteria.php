<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Criteria;

use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\IsValueObject;

/**
 * Class Criteria
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Criteria
 */
final class Criteria implements ValueObject
{
    use IsValueObject;

    /**
     * The filters collection.
     *
     * @var FilterGroup
     */
    private FilterGroup $filters;

    /**
     * Criteria order statement.
     *
     * @var Order
     */
    private Order $order;

    /**
     * Criteria pagination.
     *
     * @var Page
     */
    private Page $page;

    /**
     * Criteria constructor.
     *
     * @param  FilterGroup<Filter>  $filters
     * @param  Order  $order
     * @param  Page  $page
     */
    public function __construct(FilterGroup $filters, Order $order, Page $page)
    {
        $this->initialize(['filters' => $filters, 'order' => $order, 'page' => $page]);
    }

    public function filters(): FilterGroup
    {
        return $this->filters;
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function orderBy(): string
    {
        return $this->order->by();
    }

    public function orderType(): string
    {
        return $this->order->type();
    }

    public function page(): Page
    {
        return $this->page;
    }

    public function pageOffset(): int
    {
        return $this->page->offset();
    }

    public function pageLimit(): int
    {
        return $this->page->limit();
    }

    public function __toString(): string
    {
        return sprintf('%s#%s#%s', $this->filters, $this->order, $this->page);
    }
}
