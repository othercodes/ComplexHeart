<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Criteria;

use Countable;
use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\IsValueObject;

/**
 * Class FilterGroup
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Criteria
 */
final class FilterGroup implements ValueObject, Countable
{
    use IsValueObject;

    /**
     * List of filter in the group.
     *
     * @var Filter[]
     */
    private array $filters;

    /**
     * FilterGroup constructor.
     *
     * @param  Filter  ...$filters
     */
    public function __construct(Filter ...$filters)
    {
        $this->initialize(['filters' => $filters]);
    }

    public static function create(array $filters): FilterGroup
    {
        return new self(...array_map(fn(array $filter) => Filter::create(...$filter), $filters));
    }

    public function add(Filter $filter): FilterGroup
    {
        return new self(array_merge($this->filters, [$filter]));
    }

    public function filters(): array
    {
        return $this->filters;
    }

    public function count(): int
    {
        return count($this->filters);
    }

    public function __toString(): string
    {
        return implode('+', $this->filters);
    }
}
