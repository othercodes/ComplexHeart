<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Contracts;

/**
 * Interface Entity
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Contracts
 */
interface Entity
{
    /**
     * Return the Identifier instance.
     *
     * @return Identifier
     */
    public function id(): Identifier;
}
