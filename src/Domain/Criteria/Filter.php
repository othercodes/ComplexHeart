<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Criteria;

use ReflectionClass;
use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\IsValueObject;

/**
 * Class Filter
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Criteria
 */
final class Filter implements ValueObject
{
    use IsValueObject;

    public const EQUAL = '=';
    public const NOT_EQUAL = '!=';
    public const GT = '>';
    public const GTE = '>=';
    public const LT = '<';
    public const LTE = '<=';
    public const IN = 'in';
    public const NOT_IN = 'notIn';
    public const LIKE = 'like';

    /**
     * The filter field name.
     *
     * @var string
     */
    private string $field;

    /**
     * The filter operator.
     *
     * @var string
     */
    private string $operator;

    /**
     * The filter field value.
     *
     * @var mixed
     */
    private $value;

    /**
     * Internal cache.
     *
     * @var array
     */
    protected static array $cache = [];

    /**
     * Filter constructor.
     *
     * @param  string  $field
     * @param  string  $operator
     * @param  string  $value
     */
    public function __construct(string $field, string $operator, string $value)
    {
        $this->initialize(['field' => $field, 'operator' => $operator, 'value' => $value]);
    }

    final protected function invariantFieldValueMustNotBeEmptyString(): bool
    {
        return !empty($this->field);
    }

    final protected function invariantOperatorValueMustBeOneOfTheList(): bool
    {
        if (!isset(self::$cache[self::class])) {
            self::$cache[self::class] = (new ReflectionClass(self::class))->getConstants();
        }

        return in_array($this->operator, self::$cache[self::class], true);
    }

    /**
     * Named constructor, create a new Filter object.
     *
     * @param  string  $field
     * @param  string  $operator
     * @param  mixed   $value
     *
     * @return Filter
     */
    public static function create(string $field, string $operator, $value): Filter
    {
        return new self($field, $operator, $value);
    }

    /**
     * Retrieve the filter field value object.
     *
     * @return string
     */
    public function field(): string
    {
        return $this->field;
    }

    public function operator(): string
    {
        return $this->operator;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return sprintf('%s.%s.%s', $this->field(), $this->operator(), $this->value());
    }
}
