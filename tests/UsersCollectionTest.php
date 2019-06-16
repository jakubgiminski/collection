<?php declare(strict_types=1);

namespace Comquer\Collection\Tests;

use Comquer\Collection\Examples\Users\User;
use Comquer\Collection\Examples\Users\UsersCollection;
use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\UnintentionallyCoveredCodeError;

class UsersCollectionTest extends TestCase
{
    public function testCanBeCreatedEmpty(): void
    {
        self::assertInstanceOf(
            UsersCollection::class,
            new UsersCollection()
        );
    }

    public function testCanBeInstantiatedWithUsers(): void
    {
        $users = new UsersCollection([
            new User(1, 'Bill'),
            new User(2, 'John'),
            new User(3, 'Maria'),
        ]);

        self::assertCount(3, $users);
    }

    public function testCanAddUsers(): void
    {
        $users = new UsersCollection();
        $users->add(new User(1,'Bill'));
        $users->add(new User(2,'John'));
        $users->add(new User(3,'Maria'));

        self::assertCount(3, $users);
    }

    public function testCanRemoveAUser(): void
    {
        $users = new UsersCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        $users->remove($maria);

        self::assertCount(1, $users);
    }

    public function testCanGetAUserByUniqueIndex(): void
    {
        $users = new UsersCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        self::assertSame($john, $users->get(2));
    }

    public function testCanCheckIfContainsAUserByUniqueIndex(): void
    {
        $users = new UsersCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        self::assertTrue($users->contains(2));
    }

    public function testCanCheckIfDoesNotContainAUserByUniqueIndex(): void
    {
        $users = new UsersCollection([
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

        new UsersCollection(['invalid type']);
    }

    public function testThrowsExceptionInCaseOfDuplicatedUniqueIndex(): void
    {
        $users = new UsersCollection([new User(1, 'John')]);

        $exception = UniqueIndexException::duplicateIndex(1);
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $users->add(new User(1, 'Bill'));
    }

    public function testMerge()
    {
        $users = new UsersCollection([
            new User(1, 'Chris'),
            new User(2, 'Jakub'),
        ]);

        $moreUsers = new UsersCollection([
           new User(3, 'Rob'),
        ]);

        $totalSize = $users->count() + $moreUsers->count();
        $users->merge($moreUsers);

        self::assertCount($totalSize, $users);
    }

    public function testFilter()
    {
        $users = new UsersCollection([
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
}