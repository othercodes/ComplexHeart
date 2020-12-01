<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

use OtherCode\ComplexHeart\Domain\Contracts\Identifier;

/**
 * Trait HasIdentity
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait HasIdentity
{
    /**
     * Identity configuration.
     *
     * - field: define the field that is used by Id.
     *
     * @var array<string, string>
     */
    private array $_identity = [
        'field' => 'id',
    ];

    /**
     * Return the id instance.
     *
     * @return Identifier
     */
    public function id(): Identifier
    {
        return $this->{$this->_identity['field']};
    }

    /**
     * Invariant: Check if the class has or not an id field.
     *
     * @return bool
     */
    protected function invariantEntityMustHaveIdentityField(): bool
    {
        return isset($this->{$this->_identity['field']});
    }
}
