<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain;

use Illuminate\Support\Collection as BaseCollection;
use OtherCode\ComplexHeart\Domain\Exceptions\InvariantViolation;
use OtherCode\ComplexHeart\Domain\Traits\HasInvariants;

/**
 * Class Collection
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain
 */
class Collection extends BaseCollection
{
    use HasInvariants;

    /**
     * The total amount of item in the data source.
     *
     * @var int
     */
    private int $total;

    /**
     * The amount of items per page.
     *
     * @var int
     */
    private int $perPage;

    /**
     * The type of each items in the collection.
     *
     * @var string
     */
    protected string $valueType = 'mixed';

    /**
     * The type of each keys in the collection.
     *
     * @var string
     */
    protected string $keyType = 'mixed';

    /**
     * Collection constructor.
     *
     * @param  array  $items
     * @param  int  $total
     * @param  int  $perPage
     */
    public function __construct(array $items = [], int $total = 0, int $perPage = 0)
    {
        parent::__construct($items);

        $this->total = $total === 0 ? $this->count() : $total;
        $this->perPage = $perPage === 0 ? $this->count() : $perPage;

        $this->check();
    }

    /**
     * Invariant: Amount of items must be less or equals than items per page.
     *
     * @return bool
     */
    protected function invariantAmountOfItemsMustBeLessOrEqualsThanItemsPerPage(): bool
    {
        return $this->count() <= $this->perPage();
    }

    /**
     * Invariant: Amount of items must be less or equals than total items.
     *
     * @return bool
     */
    protected function invariantAmountOfItemsMustBeLessOrEqualsThanTotalItems(): bool
    {
        return $this->count() <= $this->total();
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

            foreach ($this->items as $index => $item) {
                if ($check($item)) {
                    throw new InvariantViolation("All items must be type of {$this->valueType}");
                }
            }
        }

        return true;
    }

    /**
     * Invariant: Check the collection keys to match the required type.
     *
     * Supported types:
     *  - string
     *  - integer
     *
     * @return bool
     * @throws InvariantViolation
     */
    protected function invariantKeysMustMatchTheRequiredType(): bool
    {
        if ($this->keyType !== 'mixed') {
            $supported = ['string', 'integer'];
            if (!in_array($this->keyType, $supported)) {
                throw new InvariantViolation(
                    "Unsupported key type, must be one of ".implode(', ', $supported)
                );
            }

            foreach ($this->items as $index => $item) {
                if (gettype($index) !== $this->keyType) {
                    throw new InvariantViolation("All keys must be type of {$this->keyType}");
                }
            }
        }
        return true;
    }

    /**
     * Return the total amount of items on the data source.
     *
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * Return the amount of items per page.
     *
     * @return int
     */
    public function perPage(): int
    {
        return $this->perPage;
    }
}
