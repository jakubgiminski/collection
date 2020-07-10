<?php declare(strict_types=1);

namespace Comquer\Collection;

use Countable;
use Iterator;

abstract class Collection implements Countable, Iterator
{
    private array $elements;

    private ?Type $type;

    private ?UniqueIndex $uniqueIndex;

    protected function __construct(array $elements, Type $type = null, UniqueIndex $uniqueIndex = null)
    {
        $this->elements = [];
        $this->type = $type;
        $this->uniqueIndex = $uniqueIndex;

        foreach ($elements as $element) {
            $this->add($element);
        }
    }

    public function add($element) : self
    {
        if ($this->isTyped()) {
            $this->type->validate($element);
        }

        if ($this->hasUniqueIndex()) {
            $this->uniqueIndex->validate($element, $this->elements);
        }

        $this->elements[] = $element;

        return $this;
    }

    public function addMany(self $collection) : void
    {
        foreach ($collection as $element) {
            $this->add($element);
        }
    }

    public function remove($redundantElement) : self
    {
        foreach ($this->elements as $key => $element) {
            if ($element == $redundantElement) {
                unset($this->elements[$key]);
            }
        }

        return $this;
    }

    public function get($uniqueIndex)
    {
        if (!$this->hasUniqueIndex()) {
            throw UniqueIndexException::indexMissing($uniqueIndex);
        }

        foreach ($this->elements as $element) {
            if (($this->uniqueIndex)($element) === $uniqueIndex) {
                return $element;
            }
        }

        throw NotFoundException::elementNotFound($uniqueIndex);
    }

    public function contains($uniqueIndex) : bool
    {
        try {
            $this->get($uniqueIndex);
            return true;
        } catch (NotFoundException $exception) {
            return false;
        }
    }

    public function count() : int
    {
        return count($this->elements);
    }

    public function getElements() : array
    {
        return $this->elements;
    }

    public function isTyped() : bool
    {
        return $this->type instanceof Type;
    }

    public function hasUniqueIndex() : bool
    {
        return $this->uniqueIndex instanceof UniqueIndex;
    }

    public function rewind()
    {
        return reset($this->elements);
    }

    public function current()
    {
        return current($this->elements);
    }

    public function key()
    {
        return key($this->elements);
    }

    public function next()
    {
        return next($this->elements);
    }

    public function valid()
    {
        return key($this->elements) !== null;
    }

    public function isEmpty() : bool
    {
        return empty($this->elements);
    }

    public function filter(callable $filter) : self
    {
        $filteredCollection = new static([]);

        foreach ($this as $element) {
            if ($filter($element)) {
                $filteredCollection->add($element);
            }
        }

        return $filteredCollection;
    }

    public function sortDescending(callable $getParameter) : self
    {
        $elements = $this->getElements();

        usort($elements, function ($element, $nextElement) use ($getParameter) {
            if ($getParameter($element) > $getParameter($nextElement)) {
                return -1;
            }

            if ($getParameter($element) < $getParameter($nextElement)) {
                return 1;
            }

            return 0;
        });

        return new static($elements);
    }

    public function sortAscending(callable $getParameter) : self
    {
        return new static(array_reverse($this->sortDescending($getParameter)->getElements()));
    }

    public function getLast()
    {
        $elements = $this->getElements();
        return end($elements);
    }
}