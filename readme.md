# Collection
A library that lets you create collections of typed and/or unique elements.
In order to use it, simply have your collection class extend the abstract
`Collection` and set it up in the constructor.

### Installation
Minimum required php version is `7.4`
```
composer require jakubgiminski/collection
```

### Examples
Here's an example of a `UserCollection` - a collection of elements where each one
must be an instance of `User`. Also, every `User` in the collection must have a unique id.
```php
class UserCollection extends Collection
{
    public function __construct(array $users = [])
    {
        parent::__construct(
            $users,
            // Set up typing - every element must be an instance of User
            Type::object(User::class), 
            // Set up a unique index - user id
            new UniqueIndex(function (User $user) {
                return $user->getId();
            })
        );
    }
}
```
In this example we have an array collection of addresses, where the unique index is the
entire address (all the fields concatenated).
```php
class AddressCollection extends Collection
{
    public function __construct(array $addresses = [])
    {
        parent::__construct(
            $addresses,
            // Set up typing - every element must be an array
            Type::array(),
            // Set up a unique index - all the fields
            new UniqueIndex(function (array $address) {
                return $address['postCode'] . $address['street'] . $address['homeNumber'];
            })
        );
    }
}
```
`Collection` also supports primitive types such as `int` or `string`. Head to the [tests](https://github.com/jakubgiminski/collection/tree/master/tests) section to examine
more use cases. 

### Documentation
Naturally, `Collection` does what any collection would do - you can count it, iterate over it, add and remove elements.
If the collection has a unique index set, you can also get elements from the collection by that index.
```php
Collection::add($element): self;
Collection::addMany(self $collection): void;
Collection::filter(callable $filter): self;
Collection::remove($element): self;
Collection::get($uniqueIndex): self;
Collection::count(): int;
Collection::getElements(): array;
Collection::isTyped(): bool;
Collection::hasUniqueIndex(): bool;
Collection::rewind();
Collection::current();
Collection::key();
Collection::next();
Collection::valid();
Collection::isEmpty(): bool;
```
