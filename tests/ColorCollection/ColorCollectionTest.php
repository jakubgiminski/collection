<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\ColorCollection;

use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class ColorCollectionTest extends TestCase
{
    public function testCanBeCreatedEmpty(): void
    {
        self::assertInstanceOf(
            ColorCollection::class,
            new ColorCollection()
        );
    }

    public function testCanBeInstantiatedWithColors(): void
    {
        $colors = new ColorCollection(['red', 'blue', 'green']);

        self::assertCount(3, $colors);
    }

    public function testCanAddColors(): void
    {
        $colors = new ColorCollection();
        $colors->add('blue');
        $colors->add('green');
        $colors->add('yellow');

        self::assertCount(3, $colors);
    }

    public function testCanRemoveAColor(): void
    {
        $colors = new ColorCollection(['blue', 'claret', 'yellow']);

        $colors->remove('claret');

        self::assertCount(2, $colors);
    }

    public function testThrowsExceptionInCaseOfInvalidType(): void
    {
        $exception = TypeException::invalidType('string', 'integer');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new ColorCollection([1]);
    }

    public function testThrowsExceptionInCaseOfDuplicatedUniqueIndex(): void
    {
        $colors = new ColorCollection(['red', 'blue']);

        $exception = UniqueIndexException::duplicateIndex('red');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $colors->add('red');
    }
}
