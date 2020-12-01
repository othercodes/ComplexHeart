<?php

namespace OtherCode\ComplexHeart\Domain\Bus;

use DateTimeImmutable;
use Exception;
use OtherCode\ComplexHeart\Domain\Traits\HasAttributes;
use OtherCode\ComplexHeart\Domain\Traits\HasIdentity;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue;

/**
 * Class Message.
 *
 * Base class for any kind of communication between modules, services and or layers.
 * i.e:
 *  - Commands > Request > Message
 *  - Queries > Request > Message
 *  - QueryResponse > Response > Message
 *  - Events > Request > Message
 *
 * @method array payload()
 * @method string occurredOn()
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Bus
 */
abstract class Message
{
    use HasIdentity, HasAttributes;

    /**
     * The message id.
     *
     * @var UUIDValue
     */
    private UUIDValue $id;

    /**
     * Message payload.
     *
     * @var array;
     */
    private array $payload;

    /**
     * Timestamp in seconds + microseconds.
     *
     * @var string
     */
    private string $occurredOn;

    /**
     * Message constructor.
     *
     * @param  array<string, mixed>  $payload
     * @param  UUIDValue|null  $id
     * @param  DateTimeImmutable|null  $occurredOn
     *
     * @throws Exception
     */
    public function __construct(
        array $payload = [],
        ?UUIDValue $id = null,
        ?DateTimeImmutable $occurredOn = null
    ) {
        $occurredOn = is_null($occurredOn) ? new DateTimeImmutable() : $occurredOn;
        $this->hydrate(
            [
                'id'         => is_null($id) ? UUIDValue::random() : $id,
                'payload'    => $payload,
                'occurredOn' => (string)(((float)((string)$occurredOn->getTimestamp().'.'
                        .(string)$occurredOn->format('u'))) * 1000),
            ]
        );
    }

    /**
     * Return the specific key from the payload.
     *  $message = new Message(['sample' => 'Some sample txt']);
     *  $message->fromPayload('sample) // 'Some sample txt'
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function fromPayload(string $key)
    {
        return $this->payload[$key];
    }
}
