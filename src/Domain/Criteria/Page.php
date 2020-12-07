<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Criteria;

use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\IsValueObject;

/**
 * Class Page
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Criteria
 */
final class Page implements ValueObject
{
    use IsValueObject;

    /**
     * Specifies the maximum number of items to return.
     *
     * @var int
     */
    private int $limit;

    /**
     * Specifies the offset of the first item to return.
     *
     * @var int
     */
    private int $offset;

    /**
     * Page constructor.
     *
     * @param  int  $limit
     * @param  int  $offset
     */
    public function __construct(int $limit = 1000, int $offset = 0)
    {
        $this->initialize(['limit' => $limit, 'offset' => $offset]);
    }

    public static function create(int $limit = 1000, int $offset = 0): Page
    {
        return new self($limit, $offset);
    }

    final protected function invariantLimitValueMustBePositive(): bool
    {
        return $this->limit >= 0;
    }

    final protected function invariantOffsetValueMustBePositive(): bool
    {
        return $this->offset >= 0;
    }

    public function limit(): int
    {
        return $this->limit;
    }

    public function offset(): int
    {
        return $this->offset;
    }

    public function __toString(): string
    {
        return sprintf('%s.%s', $this->limit, $this->offset);
    }
}