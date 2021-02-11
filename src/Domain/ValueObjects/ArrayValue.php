<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\ValueObjects;

use Countable;
use OtherCode\ComplexHeart\Domain\Exceptions\ImmutableException;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
use Serializable;
use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * Class ArrayValue
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\ValueObjects
 */
abstract class ArrayValue extends Value implements IteratorAggregate, ArrayAccess, Serializable, Countable
{
    /**
     * The value storage.
     *
     * @var array
     */
    protected array $value;

    /**
     * Define the min amount of items for the array.
     *
     * @var int
     */
    protected int $_minItems = 0;

    /**
     * Define the max amount of items for the array.
     *
     * @var int
     */
    protected int $_maxItems = 0;

    /**
     * The type of each items in the array.
     *
     * @var string
     */
    protected string $valueType = 'mixed';

    /**
     * ArrayValue constructor.
     *
     * @param  array  $value
     */
    public function __construct(array $value = [])
    {
        $this->initialize(['value' => $value]);
    }

    /**
     * Check if the amount of items meets a minimum length.
     *
     * @return bool
     * @throws InvariantViolation
     */
    protected function invariantMustHaveMinimumNumberOfElements(): bool
    {
        $amount = count($this->value);
        if ($this->_minItems > 0 && $amount < $this->_minItems) {
            throw new InvariantViolation(
                "Min of {$this->_minItems} items is required, given {$amount}"
            );
        }

        return true;
    }

    /**
     * Invariant: All items must be of the same type.
     *
     * - If $typeOf is primitive check the type with gettype().
     * - If $typeOf is a class, check if the item is an instance of it.
     *
     * @return bool
     * @throws InvariantViolation
     */
    protected function invariantItemsMustMatchTheRequiredType(): bool
    {
        if ($this->valueType !== 'mixed') {
            $primitives = ['integer', 'boolean', 'float', 'string', 'array', 'object', 'callable'];
            $check = in_array($this->valueType, $primitives)
                ? fn($value): bool => gettype($value) !== $this->valueType
                : fn($value): bool => !($value instanceof $this->valueType);

            foreach ($this->value as $index => $item) {
                if ($check($item)) {
                    throw new InvariantViolation("All items must be type of {$this->valueType}");
                }
            }
        }

        return true;
    }

    /**
     * Check if the amount of items meets a minimum length.
     *
     * @return bool
     * @throws InvariantViolation
     */
    protected function invariantMustHaveMaximumNumberOfElements(): bool
    {
        $amount = count($this->value);
        if ($this->_maxItems > 0 && $amount > $this->_maxItems) {
            throw new InvariantViolation(
                "Max of {$this->_maxItems} items exceeded, given {$amount} items."
            );
        }

        return true;
    }

    /**
     * Retrieve an external iterator.
     *
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->value);
    }

    /**
     * Whether a offset exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->value[$offset]);
    }

    /**
     * Offset to retrieve.
     *
     * @param  mixed  $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset)
            ? $this->value[$offset]
            : null;
    }

    /**
     * Offset to set.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new ImmutableException("Illegal attempt of change immutable value on offset {$offset}");
    }

    /**
     * Offset to unset.
     *
     * @param  mixed  $offset
     */
    public function offsetUnset($offset): void
    {
        throw new ImmutableException("Illegal attempt of unset immutable value on offset {$offset}");
    }

    /**
     * String representation of object.
     *
     * @return string|null
     */
    public function serialize(): ?string
    {
        return serialize($this->value);
    }

    /**
     * Constructs the object.
     *
     * @param  string  $serialized
     */
    public function unserialize($serialized): void
    {
        $this->value = unserialize($serialized);
    }

    /**
     * Count elements of an object.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->value);
    }

    /**
     * To string value.
     *
     * @return string
     */
    public function __toString(): string
    {
        return json_encode($this->value);
    }
}