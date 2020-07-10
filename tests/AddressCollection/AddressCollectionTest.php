<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\AddressCollection;

use Comquer\Collection\TypeException;
use Comquer\Collection\UniqueIndexException;
use PHPUnit\Framework\TestCase;

class AddressCollectionTest extends TestCase
{
    /** @test */
    function can_be_instantiated_with_elements_and_counted()
    {
        $addresses = new AddressCollection([
            Address::BUCKINGHAM_PALACE,
            Address::EIFFEL_TOWER,
            Address::COLOSSEUM,
        ]);

        self::assertCount(3, $addresses);
    }

    /** @test */
    function can_have_element_added()
    {
        $addresses = new AddressCollection();
        $addresses->add(Address::COLOSSEUM);
        $addresses->add(Address::EIFFEL_TOWER);

        self::assertCount(2, $addresses);
    }

    /** @test */
    function can_have_element_removed()
    {
        $addresses = new AddressCollection([
            Address::BUCKINGHAM_PALACE,
            Address::EIFFEL_TOWER,
            Address::COLOSSEUM,
        ]);

        $addresses->remove(Address::COLOSSEUM);

        self::assertCount(2, $addresses);
    }

    /** @test */
    function can_have_element_retrieved()
    {
        $colosseum = Address::COLOSSEUM;

        $addresses = new AddressCollection([
            Address::BUCKINGHAM_PALACE,
            Address::EIFFEL_TOWER,
            $colosseum
        ]);

        $index = $colosseum['postCode'] . $colosseum['street'] . $colosseum['homeNumber'];

        self::assertSame($colosseum, $addresses->get($index));
    }

    /** @test */
    function throws_excpetion_for_invalid_type()
    {
        $exception = TypeException::invalidType('array', 'string');
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        new AddressCollection(['invalid type']);
    }

    /** @test */
    function throws_exception_for_duplicate_element()
    {
        $colosseum = Address::COLOSSEUM;

        $addresses = new AddressCollection([
            Address::BUCKINGHAM_PALACE,
            Address::EIFFEL_TOWER,
            $colosseum
        ]);

        $index = $colosseum['postCode'] . $colosseum['street'] . $colosseum['homeNumber'];

        $exception = UniqueIndexException::duplicateIndex($index);
        $this->expectException(get_class($exception));
        $this->expectExceptionMessage($exception->getMessage());

        $addresses->add($colosseum);
    }

    /** @test */
    function can_be_iterated_over()
    {
        $addresses = new AddressCollection([
            Address::BUCKINGHAM_PALACE,
            Address::EIFFEL_TOWER,
            Address::COLOSSEUM,
        ]);

        $iterations = 0;

        foreach ($addresses as $address) {
            $iterations++;
        }

        self::assertSame(3, $iterations);
    }

    /** @test */
    public function knows_if_its_empty()
    {
        self::assertTrue(
            (new AddressCollection())->isEmpty()
        );

        self::assertFalse(
            (new AddressCollection([Address::COLOSSEUM]))->isEmpty()
        );
    }
}