<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Bus;

use Exception;

/**
 * Class Event
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Bus
 */
abstract class Event extends Message
{
    /**
     * Event constructor.
     *
     * @param  string  $aggregateId
     * @param  array  $data
     *
     * @throws Exception
     */
    public function __construct(string $aggregateId, array $data = [])
    {
        parent::__construct(array_merge(['aggregateId' => $aggregateId], $data));
    }

    /**
     * Return the Aggregate Id.
     *
     * @return string
     */
    public function aggregateId(): string
    {
        return $this->fromPayload('aggregateId');
    }
}
