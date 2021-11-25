<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Domain\Traits;

use function Lambdish\Phunctional\map;

/**
 * Trait HasAttributes
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Domain\Traits
 */
trait HasAttributes
{
    /**
     * Static property to keep cached attributes list to optimize performance.
     * @var array<array<string, mixed>>
     */
    private static array $_attributesCache = [];

    /**
     * Static property to keep cached string keys to optimize performance
     * @var array<string, string>
     */
    private static array $_stringKeysCache = [];

    /**
     * Return the list of attributes of the current class.
     * Properties starting with "_" will be considered as internal use only.
     *
     * @return array<string>
     */
    final public static function attributes(): array
    {
        if (empty(static::$_attributesCache[static::class])) {
            static::$_attributesCache[static::class] = array_filter(
                array_keys(get_class_vars(static::class)),
                fn(string $item) => strpos($item, '_') !== 0
            );
        }
        return static::$_attributesCache[static::class];
    }

    /**
     * Return the attribute values.
     * Properties starting with "_" will be considered as internal use only.
     *
     * @return array<string, mixed>
     */
    final public function values(): array
    {
        $allowed = static::attributes();

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
     * Get the required attribute value.
     *
     * @param  string  $attribute
     *
     * @return mixed|null
     */
    final protected function get(string $attribute)
    {
        if (in_array($attribute, static::attributes())) {
            $method = $this->getStringKey($attribute, 'get', 'Value');

            return ($this->canCall($method))
                ? call_user_func_array([$this, $method], [$this->{$attribute}])
                : $this->{$attribute};
        }

        return null;
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
            $method = $this->getStringKey($attribute, 'set', 'Value');

            $this->{$attribute} = ($this->canCall($method))
                ? call_user_func_array([$this, $method], [$value])
                : $value;
        }
    }

    /**
     * Return the required string key.
     * - $prefix     = 'get'
     * - $id         = 'Name'
     * - $suffix     = 'Value'
     * will be: getNameValue
     *
     * @param  string  $prefix
     * @param  string  $id
     * @param  string  $suffix
     *
     * @return string
     */
    protected function getStringKey(string $id, string $prefix = '', string $suffix = ''): string
    {
        $cacheKey = implode('-', [$id, $prefix, $suffix]);
        if (empty(static::$_stringKeysCache[$cacheKey])) {
            static::$_stringKeysCache[$cacheKey] = sprintf(
                '%s%s%s',
                $prefix,
                implode('', map(fn(string $chunk) => ucfirst($chunk), explode('_', $id))),
                $suffix
            );
        }
        return static::$_stringKeysCache[$cacheKey];
    }

    /**
     * Check if the required method name is callable.
     *
     * @param  string  $method
     *
     * @return bool
     */
    protected function canCall(string $method): bool
    {
        return method_exists($this, $method);
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
