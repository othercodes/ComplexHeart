<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

use RuntimeException;
use Doctrine\Instantiator\Instantiator;
use Doctrine\Instantiator\Exception\ExceptionInterface;

/**
 * Trait IsModel
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait IsModel
{
    use HasAttributes, HasInvariants;

    /**
     * Initialize the Model. Just as the constructor will do.
     *
     * @param  array  $source
     * @param  callable|null  $onFail
     *
     * @return static
     */
    protected function initialize(array $source, callable $onFail = null)
    {
        $this->hydrate($this->mapSource($source));
        $this->check($onFail);

        return $this;
    }

    /**
     * Restore the instance without calling __constructor of the model.
     *
     * @return static
     *
     * @throws RuntimeException
     */
    public static function wakeup()
    {
        try {
            return (new Instantiator())
                ->instantiate(static::class)
                ->initialize(func_get_args());
        } catch (ExceptionInterface $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Map the given source with the actual attributes by position, if
     * the provided array is already mapped (assoc) return it directly.
     *
     * @param  array  $source
     *
     * @return array
     */
    protected function mapSource(array $source): array
    {
        // check if the array is indexed or associative.
        $isIndexed = fn($source): bool => [] === $source
            ? false
            : array_keys($source) === range(0, count($source) - 1);

        return $isIndexed($source)
            // combine the attributes keys with the provided source values.
            ? array_combine(array_slice(static::attributes(), 0, count($source)), $source)
            // return the already mapped array source.
            : $source;
    }
}
