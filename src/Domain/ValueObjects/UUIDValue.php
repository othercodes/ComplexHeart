<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\ValueObjects;

use Exception;
use OtherCode\ComplexHeart\Domain\Contracts\Identifier;
use OtherCode\ComplexHeart\Domain\IsValueObject;
use Ramsey\Uuid\Uuid;

/**
 * Class UUIDValueObject
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\ValueObjects
 */
class UUIDValue implements Identifier
{
    use IsValueObject;

    private const RANDOM = 'random';

    /**
     * The uuid string value.
     *
     * @var string
     */
    private string $value;

    /**
     * UUIDValue constructor.
     *
     * @param  string  $value
     */
    public function __construct(string $value)
    {
        $this->initialize(
            ['value' => ($value === self::RANDOM) ? Uuid::uuid4()->toString() : $value]
        );
    }

    /**
     * Invariant: Value must be compliance with any UUID version.
     *
     * @return bool
     */
    protected function invariantMustBeValidUniversallyUniqueIdentifier(): bool
    {
        return Uuid::isValid($this->value());
    }

    /**
     * Return the value.
     *
     * @return string
     */
    public function value(): string
    {
        return $this->get('value');
    }

    /**
     * Generate a random UUIDValue.
     *
     * @return static
     * @throws Exception
     */
    public static function random(): self
    {
        return new static(self::RANDOM);
    }

    /**
     * To string method.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
