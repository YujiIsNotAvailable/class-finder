<?php
namespace ClassFinder\Structs;

use ClassFinder\FinderFilters;
use ClassFinder\Exceptions;

class ClassCollection implements \IteratorAggregate
{
    private array $classes = [];

    public function __construct(array $classes = [])
    {
        array_map(function(string $namespace) {
            if (!class_exists($namespace)) throw new Exceptions\InvalidClass("Class '{$namespace}' does not exists.");

            $this->classes[] = $namespace;
        }, $classes);
    }

    private function refreshIndex(): void
    {
        $this->classes = array_values($this->classes);
    }

    public function add(string $path): self
    {
        $this->classes[] = $path;
        return $this;
    }

    public function delete(string $path): self
    {
        $key = array_search($path, $this->classes);
        if ($key !== false) {
            unset($this->classes[$key]);
            $this->refreshIndex();
        }
        return $this;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->classes);
    }

    public function callback(\Closure $callback): array
    {
        return array_map(fn(string $class) => $callback($class), $this->classes);
    }

    public function filter(FinderFilters $filters): self
    {
        return $filters->apply($this);
    }

}