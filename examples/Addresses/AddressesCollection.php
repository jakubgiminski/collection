<?php declare(strict_types=1);

namespace Collection\Examples\Addresses;

use Collection\Collection;
use Collection\Type;
use Collection\UniqueIndex;

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