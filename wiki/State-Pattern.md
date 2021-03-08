> IMPORTANT: This feature is heavily inspired in [spatie/laravel-model-states](https://spatie.be/docs/laravel-model-states/v2/working-with-states/01-configuring-states)

Simple implementation of [State pattern](https://en.wikipedia.org/wiki/State_pattern).

Defining a state value in our aggregate is really easy we just need to create our Value object that defines our business
rules of our "state", por example the PaymentStatus of an order:

```php
class PaymentStatus extends State
{
    public const PENDING = 'pending';
    public const PAID = 'paid';
    public const CANCELLED = 'cancelled';

    protected function configure(): void
    {
        $this->defaultState(self::PENDING)
            ->allowTransition(self::PENDING, self::PAID)
            ->allowTransition(self::PENDING, self::CANCELLED);
    }
}
```

As we can se above the definition is really simple we only need to implement the `configure()` method, defining the
default state, and the allowed state transitions using the `defaultState()` and `allowTransition()` methods.

Now we just need to use the `transitionTo()` method to change the state of our object:

```php
$state = new PaymentState();
$state->value(); // pending
$state->transitionTo(PaymentState::PAID);
$state->value(); // paid
```

The `PaymentState` object is initialized in `pending` state as we define it in the `configure()` method. But, what
happens if we try to transition to a non-allowed state?

```php
$state = new PaymentState(PaymentState::PAID);
$state->transitionTo(PaymentState::PENDING); 

// TransitionNotAllowed exception will be thrown.
```

Additionally, we can add some behavior on our object by defining some methods:

```php
class PaymentStatus extends State
{
    public const PENDING = 'pending';
    public const PAID = 'paid';
    public const CANCELLED = 'cancelled';

    private string $color;

    private int $stateChanges = 0;

    protected function configure(): void
    {
        $this->defaultState(self::PENDING)
            ->allowTransition(self::PENDING, self::PAID)
            ->allowTransition(self::PENDING, self::CANCELLED)
            ->allowTransition(self::CANCELLED, self::PENDING)
            ->allowTransition(self::PAID, self::CANCELLED);
    }

    protected function onPending(): void
    {
        $this->color = 'gray';
    }
    
    protected function onPaid(): void
    {
        $this->color = 'green';
    }
    
    protected function onCancelled(): void
    {
        $this->color = 'red';
    }
    
    protected function fromPaidToCancelled(): void
    {
        $this->stateChanges++;
    }
    
    protected function toPaid(): void
    {
        $this->stateChanges++;
    }
}
```

- `onPendig()` this method configures the object for a specific state, so for example when the PaymentStatus is
  in `paid` state, the `onPending()` method will be executed.
- `toPaid()` is executed when the transition is on going from any allowed state to `paid`, which means, the value of the
  object still the old one, in this case is `pending`. Once this method ends the value is updated to the new
  value `paid`.
- `fromPaidToCancelled()` same as above but this method will only be executed when the state changes from `paid` to
  `cancelled`. The transition from `pending` to `cancelled` will not execute this method.

The way to define these methods is pretty simple:

- `on{status in camel case}`.
- `to{status in camel case}`.
- `from{stats in camel case}To{status in camel case}`.

Finally, we can pass arbitrary arguments to the `transitionTo()` method as we can see at below:

```php
class PaymentStatus extends State
{
    public const PENDING = 'pending';
    public const PAID = 'paid';
    public const CANCELLED = 'cancelled';

    protected function configure(): void
    {
        $this->defaultState(self::PENDING)
            ->allowTransition(self::PENDING, self::PAID)
            ->allowTransition(self::PENDING, self::CANCELLED);
    }
    
    //...

    protected function fromPendingToPaid($my_color): void
    {
        // do something with $my_color
    }
}

$state = new PaymentState(PaymentState::PENDING);
$state->transitionTo(PaymentState::PAID, 'my_color_value'); 
```
