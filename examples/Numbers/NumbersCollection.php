<?php declare(strict_types=1);

namespace Collection\Examples\Numbers;

use Collection\Collection;
use Collection\Type;

class NumbersCollection extends Collection
{
    public function __construct(array $numbers = [])
    {
        parent::__construct($numbers, Type::integer());
    }
}
