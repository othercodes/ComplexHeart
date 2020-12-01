<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Contracts\Bus;

use OtherCode\ComplexHeart\Domain\Bus\Event;

/**
 * Interface EventBus
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Contracts\Bus
 */
interface EventBus
{
    /**
     * Publish event list.
     *
     * @param  Event  ...$events
     */
    public function publish(Event ...$events): void;
}
