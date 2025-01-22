<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Application\Descriptors;

use OtherCode\ComplexHeart\Application\Exceptions\DescriptorException;
use ReflectionClass;
use ReflectionException;

/**
 * Class ModelDescriptor
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Application\Descriptors
 */
final class Descriptor
{
    /**
     * @var ReflectionClass
     */
    private ReflectionClass $reflection;

    /**
     * Descriptor constructor.
     *
     * Describe the given model:
     *
     * - [x] Type: namespace
     * - [x] Model: Aggregate|Entity|ValueObject
     * - [x] Identity: property: Type
     * - [x] Equality: Identity|Value
     * - [x] Attributes: list of attributes.
     * - [x] Invariants: list of invariants.
     * - [x] Methods: list of methods.
     * - [ ] Relations: list of relations with other entities.
     *
     * @param $class
     */
    public function __construct($class)
    {
        try {
            $this->reflexion = new ReflectionClass($class);
        } catch (ReflectionException $e) {
            throw new DescriptorException($e->getMessage(), $e->getCode(), $e);
        }

//        if (in_array(IsAggregate::class, $traits)) {
//            $allMethods = $this->reflexion->getMethods();
//            $traitMethods = array_map(
//                fn(ReflectionMethod $method) => $method->getName(),
//                (new ReflectionClass(IsAggregate::class))->getMethods()
//            );
//            $invariantMethods = Product::invariants();
//
//            foreach ($allMethods as $method) {
//                if (in_array($method->getName(), $traitMethods)) {
//                    // internal use only
//                } elseif (in_array($method->getName(), $invariantMethods)) {
//                    $invariants[] = $method->getName();
//                } else {
//                    $methods[] = [
//                        'name'       => $method->getName(),
//                        'parameters' => array_map(
//                            function (ReflectionParameter $parameter): Descriptor {
//                                return new self($parameter->getName());
//                            },
//                            $method->getParameters()
//                        ),
//                    ];
//                }
//            }
//        }
    }

    public function type(): string
    {
        return $this->reflexion->getName();
    }

    public function model(): string
    {
        $traits = $this->reflexion->getTraitNames();
        if (in_array(IsAggregate::class, $traits)) {
            return 'Aggregate';
        } elseif (in_array(IsEntity::class, $traits)) {
            return 'Entity';
        } elseif (in_array(IsValueObject::class, $traits)) {
            return 'Value Object';
        } else {
            return 'Custom';
        }
    }

    public function identity(): string
    {
        switch ($this->model()) {
            case 'Aggregate';
            case 'Entity';
                return '';
            case 'ValueObject':
                return 'None';
            default:
                return 'Unknown';
        }
    }

    public function equality(): string
    {
        switch ($this->model()) {
            case 'Aggregate';
            case 'Entity';
                return 'Identity';
            case 'ValueObject':
                return 'Value';
            default:
                return 'Reference';
        }
    }

    public function attributes(): array
    {
        $attributes = [];
        foreach ($this->type()::attributes() as $attribute) {
            $attributes[$attribute] = new self(
                (string)$this->reflexion->getProperty($attribute)->getType()
            );
        }

        return $attributes;
    }

    public function invariants(): array
    {
    }
}