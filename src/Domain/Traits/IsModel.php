<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

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
     */
    protected function initialize(array $source, callable $onFail = null): void
    {
        $this->hydrate($source);
        $this->check($onFail);
    }
}
