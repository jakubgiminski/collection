<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\ColorCollection;

use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class ColorsCollectionTest extends TestCase
{
    public function testCanBeCreatedEmpty(): void
    {
        self::assertInstanceOf(
            ColorsCollection::class,
            new ColorsCollection()
        );
    }

    public function testCanBeInstantiatedWithColors(): void
    {
        $colors = new ColorsCollection(['red', 'blue', 'green']);

        self::assertCount(3, $colors);
    }

    public function testCanAddColors(): void
    {
        $colors = new ColorsCollection();
        $colors->add('blue');
        $colors->add('green');
        $colors->add('yellow');

        self::assertCount(3, $colors);
    }

    public function testCanRemoveAColor(): void
    {
        $colors = new ColorsCollection(['blue', 'claret', 'yellow']);

        $colors->remove('claret');

        self::assertCount(2, $colors);
    }

    public function testThrowsExceptionInCaseOfInvalidType(): void
    {
        $exception = TypeException::invalidType('string', 'integer');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new ColorsCollection([1]);
    }

    public function testThrowsExceptionInCaseOfDuplicatedUniqueIndex(): void
    {
        $colors = new ColorsCollection(['red', 'blue']);

        $exception = UniqueIndexException::duplicateIndex('red');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $colors->add('red');
    }
}
