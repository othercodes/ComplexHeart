<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Application;

use OtherCode\ComplexHeart\Domain\Criteria\Criteria;
use OtherCode\ComplexHeart\Domain\Criteria\Filter;
use OtherCode\ComplexHeart\Domain\Criteria\FilterGroup;
use OtherCode\ComplexHeart\Domain\Criteria\Order;
use OtherCode\ComplexHeart\Domain\Criteria\Page;

/**
 * Class CriteriaBuilder
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Application
 */
final class CriteriaBuilder
{
    private array $filters = [];

    private string $orderBy = '';

    private string $orderType = 'asc';

    private int $pageOffset = 0;

    private int $pageLimit = 1000;

    /**
     * Adds an arbitrary filter.
     *
     * @param  string  $field
     * @param  string  $operator
     * @param  mixed  $value
     * @return $this
     */
    public function filter(string $field, string $operator, $value): self
    {
        $this->filters[] = [$field, $operator, $value];
        return $this;
    }

    /**
     * Adds new filter for equals operator.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return $this
     */
    public function filterEqual(string $field, $value): self
    {
        $this->filter($field, Filter::EQUAL, $value);
        return $this;
    }

    /**
     * Adds new filter for not equals operator.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return $this
     */
    public function filterNotEqual(string $field, $value): self
    {
        $this->filter($field, Filter::NOT_EQUAL, $value);
        return $this;
    }

    /**
     * Adds new filter for greater than operator.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return $this
     */
    public function filterGreaterThan(string $field, $value): self
    {
        $this->filter($field, Filter::GT, $value);
        return $this;
    }

    /**
     * Adds new filter for greater or equal than operator.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return $this
     */
    public function filterGreaterOrEqualThan(string $field, $value): self
    {
        $this->filter($field, Filter::GTE, $value);
        return $this;
    }

    /**
     * Adds new filter for less than operator.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return $this
     */
    public function filterLessThan(string $field, $value): self
    {
        $this->filter($field, Filter::LT, $value);
        return $this;
    }

    /**
     * Adds new filter for less or equal than operator.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return $this
     */
    public function filterLessOrEqualThan(string $field, $value): self
    {
        $this->filter($field, Filter::LTE, $value);
        return $this;
    }

    /**
     * Adds new filter for in operator.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return $this
     */
    public function filterIn(string $field, $value): self
    {
        $this->filter($field, Filter::IN, $value);
        return $this;
    }

    /**
     * Adds new filter for not in operator.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return $this
     */
    public function filterNotIn(string $field, $value): self
    {
        $this->filter($field, Filter::NOT_IN, $value);
        return $this;
    }

    /**
     * Adds new filter for like operator.
     *
     * @param  string  $field
     * @param  mixed  $value
     * @return $this
     */
    public function filterLike(string $field, $value): self
    {
        $this->filter($field, Filter::LIKE, $value);
        return $this;
    }

    /**
     * Sets the order by field parameter.
     *
     * @param  string  $field
     * @return $this
     */
    public function orderedBy(string $field): self
    {
        $this->orderBy = $field;
        return $this;
    }

    /**
     * Sets the order type parameter.
     *
     * @param  string  $type
     * @return $this
     */
    public function orderedType(string $type): self
    {
        $this->orderType = $type;
        return $this;
    }

    /**
     * Set the page limit parameter.
     *
     * @param  int  $limit
     * @return $this
     */
    public function withLimit(int $limit): self
    {
        $this->pageLimit = $limit;
        return $this;
    }

    /**
     * Set the page offset parameter.
     *
     * @param  int  $offset
     * @return $this
     */
    public function withOffset(int $offset): self
    {
        $this->pageOffset = $offset;
        return $this;
    }

    /**
     * Builds the Criteria object.
     *
     * @return Criteria
     */
    public function build(): Criteria
    {
        return new Criteria(
            FilterGroup::create($this->filters),
            empty($this->orderBy) ? Order::none() : Order::create($this->orderBy, $this->orderType),
            Page::create($this->pageLimit, $this->pageOffset)
        );
    }
}
