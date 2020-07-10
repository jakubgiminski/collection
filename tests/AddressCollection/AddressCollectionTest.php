<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\AddressCollection;

use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class AddressCollectionTest extends TestCase
{
    public function testCanBeCreatedEmpty(): void
    {
        self::assertInstanceOf(
            AddressCollection::class,
            new AddressCollection()
        );
    }

    public function testCanBeInstantiatedWithAddress(): void
    {
        $addresses = new AddressCollection([
            Address::buckinghamPalace(),
            Address::eiffelTower(),
            Address::colosseum(),
        ]);

        self::assertCount(3, $addresses);
    }

    public function testCanAddAddress(): void
    {
        $addresses = new AddressCollection();
        $addresses->add(Address::colosseum());
        $addresses->add(Address::eiffelTower());

        self::assertCount(2, $addresses);
    }

    public function testCanRemoveAnAddress(): void
    {
        $addresses = new AddressCollection([
            Address::buckinghamPalace(),
            Address::eiffelTower(),
            Address::colosseum(),
        ]);

        $addresses->remove(Address::colosseum());

        self::assertCount(2, $addresses);
    }

    public function testCanGetAddressByUniqueIndex(): void
    {
        $colosseum = Address::colosseum();

        $addresses = new AddressCollection([
            Address::buckinghamPalace(),
            Address::eiffelTower(),
            $colosseum
        ]);

        $index = $colosseum['postCode'] . $colosseum['street'] . $colosseum['homeNumber'];

        self::assertSame($colosseum, $addresses->get($index));
    }

    public function testThrowsExceptionInCaseOfInvalidType(): void
    {
        $exception = TypeException::invalidType('array', 'string');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new AddressCollection(['invalid type']);
    }

    public function testThrowsExceptionInCaseOfDuplicatedUniqueIndex(): void
    {
        $colosseum = Address::colosseum();

        $addresses = new AddressCollection([
            Address::buckinghamPalace(),
            Address::eiffelTower(),
            $colosseum
        ]);

        $index = $colosseum['postCode'] . $colosseum['street'] . $colosseum['homeNumber'];

        $exception = UniqueIndexException::duplicateIndex($index);
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $addresses->add($colosseum);
    }

    public function testCanBeIteratedOver(): void
    {
        $addresses = new AddressCollection([
            Address::buckinghamPalace(),
            Address::eiffelTower(),
            Address::colosseum(),
        ]);

        $iterations = 0;

        foreach ($addresses as $address) {
            $iterations++;
        }

        self::assertSame(3, $iterations);
    }

    public function testCanTellIfIsEmpty(): void
    {
        $addresses = new AddressCollection();
        self::assertTrue(
            $addresses->isEmpty()
        );
    }

    public function testCanTellIfIsNotEmpty(): void
    {
        $addresses = new AddressCollection([
            Address::buckinghamPalace()
        ]);


        self::assertFalse(
            $addresses->isEmpty()
        );
    }
}
