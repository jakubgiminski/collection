<?php declare(strict_types=1);

namespace Comquer\Collection;

class UniqueIndex
{
    private $getElement;

    public function __construct(callable $getElement)
    {
        $this->getElement = $getElement;
    }

    public function __invoke($element)
    {
        return ($this->getElement)($element);
    }

    public function validate($newElement, array $elements): void
    {
        $index = ($this->getElement)($newElement);
        foreach ($elements as $element) {
            if (($this->getElement)($element) === $index) {
                throw UniqueIndexException::duplicateIndex($index);
            }
        }
    }
}