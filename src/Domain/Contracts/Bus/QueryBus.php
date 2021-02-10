<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Contracts\Bus;

use OtherCode\ComplexHeart\Domain\Bus\Query;
use OtherCode\ComplexHeart\Domain\Bus\Response;

/**
 * Interface QueryBus
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Contracts\Bus
 */
interface QueryBus
{
    /**
     * Ask the given query.
     *
     * @param  Query  $query
     *
     * @return mixed
     */
    public function ask(Query $query): Response;
}
