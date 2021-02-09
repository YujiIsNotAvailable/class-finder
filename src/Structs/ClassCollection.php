<?php
namespace ClassFinder;

class ClassCollection implements \IteratorAggregate
{
    private array $classes = [];

    public function __construct(array $classes = [])
    {
        array_map(function(string $namespace) {
            if (!class_exists($namespace)) throw new \Exception("Namespace $namespace does not exists.");

            $this->classes[] = $namespace;
        }, $classes);
    }


    public function add(string $path): self
    {
        $this->classes[] = $path;
        return $this;
    }

    public function delete(string $path): self
    {
        $key = array_search($path, $this->classes);
        if ($key) unset($this->classes[$key]);
        return $this;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->classes);
    }

    public function filter(FinderFilters $filters): self
    {
        return $filters->apply($this);
    }

}