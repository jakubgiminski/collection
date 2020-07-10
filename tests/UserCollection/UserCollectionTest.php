<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\UserCollection;

use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class UserCollectionTest extends TestCase
{
    public function testCanBeCreatedEmpty(): void
    {
        self::assertInstanceOf(
            UserCollection::class,
            new UserCollection()
        );
    }

    public function testCanBeInstantiatedWithUsers(): void
    {
        $users = new UserCollection([
            new User(1, 'Bill'),
            new User(2, 'John'),
            new User(3, 'Maria'),
        ]);

        self::assertCount(3, $users);
    }

    public function testCanAddUsers(): void
    {
        $users = new UserCollection();
        $users->add(new User(1,'Bill'));
        $users->add(new User(2,'John'));
        $users->add(new User(3,'Maria'));

        self::assertCount(3, $users);
    }

    public function testCanRemoveAUser(): void
    {
        $users = new UserCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        $users->remove($maria);

        self::assertCount(1, $users);
    }

    public function testCanGetAUserByUniqueIndex(): void
    {
        $users = new UserCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        self::assertSame($john, $users->get(2));
    }

    public function testCanCheckIfContainsAUserByUniqueIndex(): void
    {
        $users = new UserCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        self::assertTrue($users->contains(2));
    }

    public function testCanCheckIfDoesNotContainAUserByUniqueIndex(): void
    {
        $users = new UserCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        self::assertFalse($users->contains(3));
    }

    public function testThrowsExceptionInCaseOfInvalidType(): void
    {
        $exception = TypeException::invalidType(User::class, 'string');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new UserCollection(['invalid type']);
    }

    public function testThrowsExceptionInCaseOfDuplicatedUniqueIndex(): void
    {
        $users = new UserCollection([new User(1, 'John')]);

        $exception = UniqueIndexException::duplicateIndex(1);
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $users->add(new User(1, 'Bill'));
    }

    public function testAddMany(): void
    {
        $users = new UserCollection([
            new User(1, 'Chris'),
            new User(2, 'Jakub'),
        ]);

        $moreUsers = new UserCollection([
           new User(3, 'Rob'),
        ]);

        $numberOfUsers = $users->count() + $moreUsers->count();

        $users->addMany($moreUsers);

        self::assertCount($numberOfUsers, $users);
    }

    public function testFilter(): void
    {
        $users = new UserCollection([
           new User(1, 'George'),
           new User(2, 'George'),
           new User(3, 'Chris'),
           new User(4, 'Jakub'),
           new User(5, 'George'),
        ]);

        $georges = $users->filter(function (User $user) {
           return $user->getName() === 'George';
        });

        self::assertCount(3, $georges);

        /** @var User $george */
        foreach ($georges as $george) {
            self::assertSame('George', $george->getName());
        }
    }

    public function testSetUsersAscById(): void
    {
        $users = new UserCollection([
            new User(4, 'Jakub'),
            new User(1, 'George'),
            new User(3, 'Chris'),
            new User(2, 'George'),
            new User(5, 'George'),
        ]);

        $sortedUsers = $users->sortAscending(function (User $user) : int {
            return $user->getId();
        });

        $id = 0;
        /** @var User $user */
        foreach ($sortedUsers as $user) {
            self::assertSame($id + 1, $user->getId());
            $id++;
        }
    }
}