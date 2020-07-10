<?php declare(strict_types=1);

namespace Comquer\Collection;

class Type
{
    private string $genericType;

    private string $type;

    private function __construct(string $genericType, string $type)
    {
        $this->genericType = $genericType;
        $this->type = $type;
    }

    public static function object(string $className) : self
    {
       return new self('object', $className);
    }

    public static function array() : self
    {
        return new self('array', 'array');
    }

    public static function integer() : self
    {
        return new self('scalar', 'integer');
    }

    public static function string() : self
    {
        return new self('scalar', 'string');
    }

    public static function float() : self
    {
        return new self('scalar', 'float');
    }

    public static function scalar(string $type) : self
    {
        return new self('scalar', $type);
    }

    public function isObject() : bool
    {
        return $this->genericType === 'object';
    }

    public function isArray() : bool
    {
        return $this->equals(Type::array());
    }

    public function isScalar() : bool
    {
        return $this->genericType === 'scalar';
    }

    public function equals(self $type) : bool
    {
        return (string) $this === (string) $type;
    }

    public function __toString() : string
    {
        return $this->genericType . $this->type;
    }

    public function validate($element) : void
    {
        if ($this->isObject() && !$element instanceof $this->type) {
            $type = is_object($element) ? get_class($element) : gettype($element);
            throw TypeException::invalidType($this->type, $type);
        }

        if ($this->isArray() && !is_array($element)) {
            throw TypeException::invalidType('array', gettype($element));
        }

        if ($this->isScalar() && gettype($element) !== $this->type) {
            throw TypeException::invalidType($this->type, gettype($element));
        }
    }
}