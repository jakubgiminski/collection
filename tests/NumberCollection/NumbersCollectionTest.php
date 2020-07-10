<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\NumberCollection;

use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class NumbersCollectionTest extends TestCase
{
    public function testCanBeCreatedEmpty(): void
    {
        self::assertInstanceOf(NumbersCollection::class, new NumbersCollection());
    }

    public function testCanBeInstantiatedWithNumbers(): void
    {
        $numbers = new NumbersCollection([111, 222, 333]);

        self::assertCount(3, $numbers);
    }

    public function testCanAddNumbers(): void
    {
        $numbers = new NumbersCollection();
        $numbers->add(111);
        $numbers->add(222);
        $numbers->add(333);

        self::assertCount(3, $numbers);
    }

    public function testCanRemoveNumbers(): void
    {
        $numbers = new NumbersCollection([1, 2, 2, 2, 2, 3]);

        $numbers->remove(2);

        self::assertCount(2, $numbers);
    }

    public function testThrowsExceptionOnGetBecauseOfAMissingIndex(): void
    {
        $exception = UniqueIndexException::indexMissing(123);
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        (new NumbersCollection([123]))->get(123);
    }

    public function testThrowsExceptionInCaseOfInvalidType(): void
    {
        $exception = TypeException::invalidType('integer', 'string');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new NumbersCollection(['invalid type']);
    }
}
