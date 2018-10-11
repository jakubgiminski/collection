<?php declare(strict_types=1);

namespace Collection;

use InvalidArgumentException;

class DuplicateIndexException extends InvalidArgumentException
{
    public static function create($index): self
    {
        return new self("Element with index $index already exists in the collection");
    }
}