<?php
namespace ClassFinder\Filters;

class ShouldImplements implements IFilter
{
    private array $classes = [];
    public function __construct(array $classes = [])
    {
        $this->classes = $classes;
    }

    /**
     * Check if namespace extends all of $this->classes;
     */
    public function check(string $namespace): bool
    {
        foreach ($this->classes as $class) {
            if (!in_array($namespace, class_implements($class))) return false;
        }
        return true;
    }
}