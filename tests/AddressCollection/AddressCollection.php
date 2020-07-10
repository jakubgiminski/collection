<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\AddressCollection;

use Comquer\Collection\Collection;
use Comquer\Collection\Type;
use Comquer\Collection\UniqueIndex;

class AddressCollection extends Collection
{
    public function __construct(array $addresses = [])
    {
        parent::__construct(
            $addresses,
            Type::array(),
            new UniqueIndex(function (array $address) : string {
                return $address['postCode'] . $address['street'] . $address['homeNumber'];
            })
        );
    }
}