<?php declare(strict_types=1);

namespace Comquer\Collection\Examples\Colors;

use Comquer\Collection\Collection;
use Comquer\Collection\Type;
use Comquer\Collection\UniqueIndex;

class ColorsCollection extends Collection
{
    public function __construct(array $colors = [])
    {
        parent::__construct(
            $colors,
            Type::string(),
            new UniqueIndex(function (string $color) {
                return $color;
            })
        );
    }
}