<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Contracts\Bus;

use OtherCode\ComplexHeart\Domain\Bus\Command;

/**
 * Interface CommandBus
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Contracts\Bus
 */
interface CommandBus
{
    /**
     * Dispatch the given command.
     *
     * @param  Command  $command
     */
    public function dispatch(Command $command): void;
}
