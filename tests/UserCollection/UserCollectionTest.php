<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\UserCollection;

use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class UserCollectionTest extends TestCase
{
    /** @test */
    function can_be_instantiated_with_elements_and_counted()
    {
        $users = new UserCollection([
            new User(1, 'Bill'),
            new User(2, 'John'),
            new User(3, 'Maria'),
        ]);

        self::assertCount(3, $users);
    }

    /** @test */
    function can_have_elements_added()
    {
        $users = new UserCollection();
        $users->add(new User(1,'Bill'));
        $users->add(new User(2,'John'));
        $users->add(new User(3,'Maria'));

        self::assertCount(3, $users);
    }

    /** @test */
    function can_have_element_removed()
    {
        $users = new UserCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        $users->remove($maria);

        self::assertCount(1, $users);
    }

    /** @test */
    function can_have_element_retrieved()
    {
        $users = new UserCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        self::assertSame($john, $users->get(2));
    }

    /** @test */
    function knows_if_contains_element()
    {
        $users = new UserCollection([
            $maria = new User(1, 'Maria'),
            $john = new User(2, 'John'),
        ]);

        self::assertTrue($users->contains(2));
        self::assertFalse($users->contains(3));
    }

    /** @test */
    function throws_excpetion_for_invalid_type()
    {
        $exception = TypeException::invalidType(User::class, 'string');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new UserCollection(['invalid type']);
    }

    /** @test */
    function throws_exception_for_duplicate_element()
    {
        $users = new UserCollection([new User(1, 'John')]);

        $exception = UniqueIndexException::duplicateIndex(1);
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $users->add(new User(1, 'Bill'));
    }

    /** @test */
    function can_have_multiple_elements_added_at_once()
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

    /** @test */
    function can_have_elements_filtered()
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

    /** @test */
    function can_have_elements_sorted()
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