<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\AddressCollection;

final class Address
{
    public const BUCKINGHAM_PALACE = [
        'postCode' => 'SW1A 1AA',
        'street' => 'Westminster',
        'homeNumber' => 'Buckingham Palace',
    ];

    public const EIFFEL_TOWER = [
        'postCode' => '75007 Paris',
        'street' => 'Avenue Anatole',
        'homeNumber' => '5',
    ];

    public const COLOSSEUM = [
        'postCode' => '00184 Roma RM',
        'street' => 'Piazza del Colosseo',
        'homeNumber' => '1',
    ];

    private function __construct()
    {
    }
}
