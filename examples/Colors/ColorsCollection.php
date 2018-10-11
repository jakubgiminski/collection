<?php declare(strict_types=1);

namespace Collection\Examples\Colors;

use Collection\Collection;
use Collection\Type;
use Collection\UniqueIndex;

class ColorsCollection extends Collection
{
    public function __construct(array $colors = [])
    {
        parent::__construct($colors, [
            Type::scalar('string'),
            new UniqueIndex(function (string $color) {
                return $color;
            })
        ]);
    }
}