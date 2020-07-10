<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\ColorCollection;

use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class ColorCollectionTest extends TestCase
{
    /** @test */
    function can_be_instantiated_with_elements_and_counted()
    {
        $colors = new ColorCollection(['red', 'blue', 'green']);

        self::assertCount(3, $colors);
    }

    /** @test */
    function can_have_elements_added()
    {
        $colors = new ColorCollection();
        $colors->add('blue');
        $colors->add('green');
        $colors->add('yellow');

        self::assertCount(3, $colors);
    }

    /** @test */
    function can_have_element_removed()
    {
        $colors = new ColorCollection(['blue', 'claret', 'yellow']);
        $colors->remove('claret');

        self::assertCount(2, $colors);
    }

    /** @test */
    function throws_excpetion_for_invalid_type()
    {
        $exception = TypeException::invalidType('string', 'integer');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new ColorCollection([1]);
    }

    /** @test */
    function throws_exception_for_duplicate_element()
    {
        $colors = new ColorCollection(['red', 'blue']);

        $exception = UniqueIndexException::duplicateIndex('red');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $colors->add('red');
    }
}
