<?php declare(strict_types=1);

namespace Comquer\Collection;

use Exception;

class NotFoundException extends Exception
{
    public static function elementNotFound($index) : self
    {
        return new self("Element with index `$index` was not found");
    }
}
