<?php declare(strict_types=1);

namespace Collection\Examples\Addresses;

class AddressesFactory
{
    public static function createForBuckinghamPalace(): array
    {
        return [
            'postCode' => 'SW1A 1AA',
            'street' => 'Westminster',
            'homeNumber' => 'Buckingham Palace',
        ];
    }

    public static function createForEiffelTower(): array
    {
        return [
            'postCode' => '75007 Paris',
            'street' => 'Avenue Anatole',
            'homeNumber' => '5',
        ];
    }

    public static function createForColosseum(): array
    {
        return [
            'postCode' => '00184 Roma RM',
            'street' => 'Piazza del Colosseo',
            'homeNumber' => '1',
        ];
    }
}