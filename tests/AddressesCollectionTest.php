<?php declare(strict_types=1);

namespace Comquer\Collection\Tests;

use Comquer\Collection\Examples\Addresses\AddressesCollection;
use Comquer\Collection\Examples\Addresses\AddressesFactory;
use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class AddressesCollectionTest extends TestCase
{
    public function testCanBeCreatedEmpty(): void
    {
        self::assertInstanceOf(
            AddressesCollection::class,
            new AddressesCollection()
        );
    }

    public function testCanBeInstantiatedWithAddresses(): void
    {
        $addresses = new AddressesCollection([
            AddressesFactory::createForBuckinghamPalace(),
            AddressesFactory::createForEiffelTower(),
            AddressesFactory::createForColosseum(),
        ]);

        self::assertCount(3, $addresses);
    }

    public function testCanAddAddresses(): void
    {
        $addresses = new AddressesCollection();
        $addresses->add(AddressesFactory::createForColosseum());
        $addresses->add(AddressesFactory::createForEiffelTower());

        self::assertCount(2, $addresses);
    }

    public function testCanRemoveAnAddress(): void
    {
        $addresses = new AddressesCollection([
            AddressesFactory::createForBuckinghamPalace(),
            AddressesFactory::createForEiffelTower(),
            AddressesFactory::createForColosseum(),
        ]);

        $addresses->remove(AddressesFactory::createForColosseum());

        self::assertCount(2, $addresses);
    }

    public function testCanGetAddressByUniqueIndex(): void
    {
        $colosseum = AddressesFactory::createForColosseum();

        $addresses = new AddressesCollection([
            AddressesFactory::createForBuckinghamPalace(),
            AddressesFactory::createForEiffelTower(),
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

        new AddressesCollection(['invalid type']);
    }

    public function testThrowsExceptionInCaseOfDuplicatedUniqueIndex(): void
    {
        $colosseum = AddressesFactory::createForColosseum();

        $addresses = new AddressesCollection([
            AddressesFactory::createForBuckinghamPalace(),
            AddressesFactory::createForEiffelTower(),
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
        $addresses = new AddressesCollection([
            AddressesFactory::createForBuckinghamPalace(),
            AddressesFactory::createForEiffelTower(),
            AddressesFactory::createForColosseum(),
        ]);

        $iterations = 0;

        foreach ($addresses as $address) {
            $iterations++;
        }

        self::assertSame(3, $iterations);
    }

    public function testCanTellIfIsEmpty(): void
    {
        $addresses = new AddressesCollection();
        self::assertTrue(
            $addresses->isEmpty()
        );
    }

    public function testCanTellIfIsNotEmpty(): void
    {
        $addresses = new AddressesCollection([
            AddressesFactory::createForBuckinghamPalace()
        ]);


        self::assertFalse(
            $addresses->isEmpty()
        );
    }
}
