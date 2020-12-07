<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Criteria;

use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\IsValueObject;

/**
 * Class Order
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Criteria
 */
final class Order implements ValueObject
{
    use IsValueObject;

    private const ORDER_TYPE_ASC = 'asc';
    private const ORDER_TYPE_DESC = 'desc';
    private const ORDER_TYPE_NONE = 'none';

    /**
     * Used to sort the result-set by specific field.
     *
     * @var string
     */
    private string $by;

    /**
     * Used to sort the result-set in ascending or descending order. Ascending order by default.
     *
     * @var string
     */
    private string $type;

    /**
     * Order constructor.
     *
     * @param  string  $by
     * @param  string  $type
     */
    public function __construct(string $by, string $type = self::ORDER_TYPE_ASC)
    {
        $this->initialize(["by" => $by, "type" => $type]);
    }

    final protected function invariantOrderByValueMustContainOnlyAlphanumericalCharacters(): bool
    {
        return preg_match('/\w*/', $this->by) === 1;
    }

    final protected function invariantOrderTypeValueMustBeOneOfAscDescOrNone(): bool
    {
        return in_array(
            $this->type,
            [self::ORDER_TYPE_ASC, self::ORDER_TYPE_DESC, self::ORDER_TYPE_NONE]
        );
    }

    public static function create(string $by, string $type = self::ORDER_TYPE_ASC): Order
    {
        return new self($by, $type);
    }

    public static function none(): Order
    {
        return self::create('', self::ORDER_TYPE_NONE);
    }

    public function by(): string
    {
        return $this->by;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function isNone(): bool
    {
        return $this->type === self::ORDER_TYPE_NONE;
    }

    public function __toString(): string
    {
        return sprintf('%s.%s', $this->by(), $this->type());
    }
}
