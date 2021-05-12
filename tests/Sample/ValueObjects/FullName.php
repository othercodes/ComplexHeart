<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample\ValueObjects;


use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\HasEquality;
use OtherCode\ComplexHeart\Domain\Traits\IsModel;

/**
 * Class FullName
 * @author Dmytro <dmytro@2amigos.us>
 * @package OtherCode\ComplexHeart\Tests\Sample\ValueObjects
 * @method string firstName()
 * @method string lastName()
 */
class FullName implements ValueObject
{
    use IsModel, HasEquality;

    private string $firstName;

    private string $lastName;

    public function __construct(string $firstName, string $lastName)
    {
        $this->initialize([$firstName, $lastName]);
    }

    public function withLastName(string $lastName): self
    {
        return $this->withOverrides(
            [
                'lastName' => $lastName
            ]
        );
    }
}
