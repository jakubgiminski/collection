<?php declare(strict_types=1);

namespace Comquer\Collection;

use RuntimeException;

class TypeException extends RuntimeException
{
    public static function invalidType(string $expected, string $actual): self
    {
        return new self("Invalid type. Expected: $expected. Actual: $actual");
    }
}