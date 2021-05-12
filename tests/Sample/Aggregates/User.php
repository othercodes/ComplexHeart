<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample\Aggregates;


use OtherCode\ComplexHeart\Domain\Contracts\Aggregate;
use OtherCode\ComplexHeart\Domain\Traits\IsAggregate;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue;

/**
 * Class User
 * @author Dmytro <dmytro@2amigos.us>
 * @package OtherCode\ComplexHeart\Tests\Sample\Aggregates
 * @method UUIDValue id()
 * @method string email()
 * @method string name()
 */
class User implements Aggregate
{
    use IsAggregate;

    private UUIDValue $id;
    private string $email;
    private string $name;

    public function __construct(UUIDValue $id, string $email, string $name)
    {
        $this->initialize([$id, $email, $name]);
        $this->registerDomainEvent(new UserCreated($id->value()));
    }

    public function withEmail(string $email): self
    {
        return $this->withOverrides(
            [
                'email' => $email
            ]
        );
    }

    public function getDomainEvents(): array
    {
        return $this->_domainEvents;
    }
}
