<?php declare(strict_types=1);

namespace Collection;

class Type
{
    private $kind;

    private $type;

    private function __construct(string $kind, string $type)
    {
        $this->kind = $kind;
        $this->type = $type;
    }

    public static function object(string $className): self
    {
       return new self('object', $className);
    }

    public static function array(): self
    {
        return new self('array', 'array');
    }

    public static function scalar(string $type): self
    {
        return new self('scalar', $type);
    }

    public function isObjectCollection(): bool
    {
        return $this->kind === 'object';
    }

    public function isArrayCollection(): bool
    {
        return $this->kind === 'array';
    }

    public function isScalarCollection(): bool
    {
        return $this->kind === 'scalar';
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function validate($element): void
    {
        if ($this->isObjectCollection() && !$element instanceof $this->type) {
            $type = is_object($element) ? get_class($element) : gettype($element);
            throw InvalidTypeException::create($this->type, $type);
        }

        if ($this->isArrayCollection() && !is_array($element)) {
            throw InvalidTypeException::create('array', gettype($element));
        }

        if ($this->isScalarCollection() && gettype($element) !== $this->type) {
            throw InvalidTypeException::create($this->type, gettype($element));
        }
    }
}