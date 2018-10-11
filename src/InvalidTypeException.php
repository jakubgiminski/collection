<?php declare(strict_types=1);

namespace Collection;

use InvalidArgumentException;

class InvalidTypeException extends InvalidArgumentException
{
    public static function create(string $expected, string $actual): self
    {
        return new self("Invalid type. Expected: $expected. Actual: $actual");
    }
}