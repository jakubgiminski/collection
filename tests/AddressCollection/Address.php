<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\AddressCollection;

final class Address
{
    private function __construct()
    {
    }

    public static function buckinghamPalace(): array
    {
        return [
            'postCode' => 'SW1A 1AA',
            'street' => 'Westminster',
            'homeNumber' => 'Buckingham Palace',
        ];
    }

    public static function eiffelTower(): array
    {
        return [
            'postCode' => '75007 Paris',
            'street' => 'Avenue Anatole',
            'homeNumber' => '5',
        ];
    }

    public static function colosseum(): array
    {
        return [
            'postCode' => '00184 Roma RM',
            'street' => 'Piazza del Colosseo',
            'homeNumber' => '1',
        ];
    }
}