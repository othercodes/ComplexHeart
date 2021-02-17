<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Exceptions;

use Exception;

/**
 * Class StateException
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Exceptions
 */
abstract class StateException extends Exception
{
    /**
     * Create a new StateNotFound
     *
     * @param  string  $state
     * @param  array  $valid
     *
     * @return StateNotFound
     */
    public static function stateNotFound(string $state, array $valid): StateException
    {
        $valid = implode(',', $valid);
        return new StateNotFound("State <{$state}> not found, must be one of: {$valid}");
    }

    /**
     * Create a new TransitionNotAllowed.
     *
     * @param  string  $from
     * @param  string  $to
     *
     * @return StateException
     */
    public static function transitionNotAllowed(string $from, string $to): StateException
    {
        return new TransitionNotAllowed("Transition from <{$from}> to <{$to}> is not allowed.");
    }
}