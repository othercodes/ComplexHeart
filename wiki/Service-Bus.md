## Service Bus: Commands, Queries and Events

The Service Bus integration contains some basic interfaces (`ServiceBus`, `CommandBus`, `QueryBus`, and `EventBus`) and
classes to build on top of them.

- `Message` Base DTO to transfer objects between layers.
    - `Request`
        - `Command` Command DTO.
        - `Event` Event DTO.
        - `Query` Query DTO.
    - `Response`

Check this small example of the query bus usage:

```php
$response = $queryBus->ask(new GetUserQuery('some-uuid-value'));
```