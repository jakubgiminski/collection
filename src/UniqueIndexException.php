<?php declare(strict_types=1);

namespace Collection;

use RuntimeException;

class UniqueIndexException extends RuntimeException
{
    public static function indexMissing($uniqueIndex): self
    {
        return new self("Can't get element by unique index ($uniqueIndex), 
            because this collection doesn't have a unique index set");
    }

    public static function duplicateIndex($index): self
    {
        return new self("Element with index $index already exists in the collection");
    }
}
