<?php declare(strict_types=1);

namespace Collection\Tests;

use Collection\Examples\Users\User;
use Collection\Examples\Users\UsersCollection;
use Collection\TypeException;
use Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

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
}