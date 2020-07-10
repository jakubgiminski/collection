<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\NumberCollection;

use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class NumberCollectionTest extends TestCase
{
    /** @test */
    function can_be_instantiated_with_elements_and_counted()
    {
        $numbers = new NumberCollection([111, 222, 333]);

        self::assertCount(3, $numbers);
    }

    /** @test */
    function can_have_elements_added()
    {
        $numbers = new NumberCollection();
        $numbers->add(111);
        $numbers->add(222);
        $numbers->add(333);

        self::assertCount(3, $numbers);
    }

    /** @test */
    function can_have_elements_removed()
    {
        $numbers = new NumberCollection([1, 2, 2, 2, 2, 3]);
        $numbers->remove(2);

        self::assertCount(2, $numbers);
    }

    /** @test */
    function throws_exception_for_get_element_not_found()
    {
        $exception = UniqueIndexException::indexMissing(123);
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        (new NumberCollection([123]))->get(123);
    }

    /** @test */
    function throws_exception_for_invalid_type()
    {
        $exception = TypeException::invalidType('integer', 'string');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new NumberCollection(['invalid type']);
    }
}
