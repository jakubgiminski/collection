<?php declare(strict_types=1);

namespace Comquer\Collection\Tests\ColorCollection;

use Comquer\Collection\Collection;
use Comquer\Collection\Type;
use Comquer\Collection\UniqueIndex;

class ColorCollection extends Collection
{
    public function __construct(array $colors = [])
    {
        parent::__construct(
            $colors,
            Type::string(),
            new UniqueIndex(function (string $color) : string {
                return $color;
            })
        );
    }
}