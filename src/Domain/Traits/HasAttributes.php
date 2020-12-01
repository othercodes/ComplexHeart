<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

/**
 * Trait HasAttributes
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait HasAttributes
{
    /**
     * Return the list of attributes of the current class.
     * Properties starting with "_" will be considered as internal use only.
     *
     * @return array<string>
     */
    final public function attributes(): array
    {
        return array_filter(
            array_keys(get_class_vars(static::class)),
            fn(string $item) => strpos($item, '_') !== 0
        );
    }

    /**
     * Return the attribute values.
     * Properties starting with "_" will be considered as internal use only.
     *
     * @return array<string, mixed>
     */
    final public function values(): array
    {
        $allowed = $this->attributes();

        return array_intersect_key(
            get_object_vars($this),
            array_combine($allowed, $allowed)
        );
    }

    /**
     * Populate the object recursively.
     *
     * @param  iterable  $source
     */
    final protected function hydrate(iterable $source): void
    {
        foreach ($source as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Set an attribute value.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    final protected function set(string $attribute, $value): void
    {
        if (in_array($attribute, $this->attributes())) {
            $this->{$attribute} = $value;
        }
    }

    /**
     * Get the required attribute value.
     *
     * @param  string  $attribute
     *
     * @return mixed|null
     */
    final protected function get(string $attribute)
    {
        return in_array($attribute, $this->attributes())
            ? $this->{$attribute}
            : null;
    }

    /**
     * Dynamic method to access each attribute as method, i.e:
     *  $user->name() will access the private attribute name.
     *
     * @param  string  $attribute
     * @param  array  $values
     *
     * @return mixed|null
     */
    public function __call(string $attribute, array $values)
    {
        return $this->get($attribute);
    }
}
