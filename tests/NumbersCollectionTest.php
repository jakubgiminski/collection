<?php declare(strict_types=1);

namespace Collection\Tests;

use Collection\Examples\Numbers\NumbersCollection;
use Collection\InvalidTypeException;
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

    public function testThrowsExceptionInCaseOfInvalidType(): void
    {
        $exception = InvalidTypeException::create('integer', 'string');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new NumbersCollection(['invalid type']);
    }
}
