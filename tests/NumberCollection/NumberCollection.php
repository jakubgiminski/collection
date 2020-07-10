<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\NumberCollection;

use Comquer\Collection\Collection;
use Comquer\Collection\Type;

class NumberCollection extends Collection
{
    public function __construct(array $numbers = [])
    {
        parent::__construct($numbers, Type::integer());
    }
}
