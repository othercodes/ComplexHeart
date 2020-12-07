<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Contracts;

use OtherCode\ComplexHeart\Domain\Bus\Event;

/**
 * Interface Aggregate
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Contracts
 */
interface Aggregate extends Entity
{
    /**
     * Pull the registered Domain Events.
     *
     * @return Event[]
     */
    public function pullDomainEvents(): array;
}
