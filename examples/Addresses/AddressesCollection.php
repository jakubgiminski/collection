<?php declare(strict_types=1);

namespace Comquer\Collection\Examples\Addresses;

use Comquer\Collection\Collection;
use Comquer\Collection\Type;
use Comquer\Collection\UniqueIndex;

class AddressesCollection extends Collection
{
    public function __construct(array $addresses = [])
    {
        parent::__construct(
            $addresses,
            Type::array(),
            new UniqueIndex(function (array $address) {
                return $address['postCode'] . $address['street'] . $address['homeNumber'];
            })
        );
    }
}