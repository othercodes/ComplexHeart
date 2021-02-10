# ComplexHeart

[![Latest Stable Version](https://poser.pugx.org/othercode/complex-heart/v)](//packagist.org/packages/othercode/complex-heart)
[![License](https://poser.pugx.org/othercode/complex-heart/license)](//packagist.org/packages/othercode/complex-heart)
![Tests](https://github.com/othercodes/ComplexHeart/workflows/Tests/badge.svg)
[![codecov](https://codecov.io/gh/othercodes/ComplexHeart/branch/main/graph/badge.svg?token=wL3xLFaT22)](https://codecov.io/gh/othercodes/ComplexHeart)

## About

The **Complex Heart** name stands from "_Domain-Driven Design: Tackling Complexity in the Heart of Software_" Eric Evans
Book. This project intends to provide a set of useful classes and tools to ease the adoption of Domain Driven Design
into your project.

## Domain Modeling: Aggregates, Entities and Value Objects

Complex Heart allows you to model your domain Aggregates, Entities, and Value Objects using a set of traits. Great, but
why traits and not classes? Well, sometimes you have some kind of inheritance in your classes. Being forced to use a
certain base class is too invasive and personally, I don't like it. By using a set of traits and interfaces you have all
the functionality you need without compromising the essence of your own domain.

Let's see a very basic example:

```php
use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\IsValueObject;

/**
 * Class Color
 * @method string value()
 */
final class Color implements ValueObject 
{
    use IsValueObject;
    
    private string $value;
 
    public function __construct(string $value) {
        $this->initialize(['value' => $value]);
    }
    
    protected function invariantValueMustBeHexadecimal(): bool {
        return preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/', $this->value) === 1;
    }
    
    public function __toString(): string {
        return $this->value();
    }
}

$red = new Color('#ff0000');
$red->equals(new Color('#00ff00')); // false
$red->value(); // #ff0000
$magenta = new Color('ff00ff'); // Exception InvariantViolation: Value must be hexadecimal.
```

To define a Value Object you only need to use the `IsValueObject` trait, this will allow you to use some functions like
`equals()` that will automatically compare the value of the objects or `initialize()` that will allow you to run
invariant validations against the object values. Optionally, and recommended, you can use the `ValueObject` interface.

The available traits are:

- `HasAttributes` Provide some functionality to manage attributes.
- `HasEquality` Provide functionality to handle equality between objects.
- `HasInvariants` Allow invariant checking on instantiation (Guard Clause).
- `HasIdentity` Define the Entity/Aggregate identity.
- `HasDomainEvents` Provide domain event management.

On top of those base traits **Complex Heart** provide ready to use compositions:

- `IsModel` composed by `HasAttributes` and `HasInvariants`
- `IsValueObject` composed by `IsModel` and `HasEquality`
- `IsEntity` composed by `IsModel`, `HasIdentity`, `HasEquality`
- `IsAggregate` composed by `IsEntity`, `HasDomainEvents`

## Service Bus: Commands, Queries and Events

The Service Bus integration contains some basic interfaces (`ServiceBus`, `CommandBus`, `QueryBus`, and `EventBus`) and
classes to build on top of them.

- `Message` Base DTO to transfer objects between layers.
    - `Request`
        - `Command` Command DTO.
        - `Event` Event DTO.
        - `Query` Query DTO.
    - `Response`

Check this small example of the usage:

```php 
$response = $queryBus->ask(new GetUserQuery('some-uuid-value'));
```

Check the [wiki](https://github.com/othercodes/ComplexHeart/wiki) for more detailed examples.

## References

- [Pro Codely TV](https://pro.codely.tv/library/)
- [martinFowler.com](https://martinfowler.com/tags/domain%20driven%20design.html)
- [Clean Architecture](https://amzn.to/2ImCugP)
- [Clean Code](https://amzn.to/3goF2HK)
- [Domain-Driven Design: Tackling Complexity in the Heart of Software](https://amzn.to/2K0gJ6S)