<?php declare(strict_types=1);

namespace Comquer\Collection\Examples\Numbers;

use Comquer\Collection\Collection;
use Comquer\Collection\Type;

class NumbersCollection extends Collection
{
    public function __construct(array $numbers = [])
    {
        parent::__construct($numbers, Type::integer());
    }
}
