<?php
namespace ClassFinder\Filters;

class ShouldImplements implements IFilter
{
    private array $interfaces = [];
    public function __construct(array $interfaces = [])
    {
        $this->interfaces = $interfaces;
    }

    /**
     * Check if namespace implements all of $this->interfaces;
     */
    public function check(string $namespace): bool
    {
        foreach ($this->interfaces as $class) {
            if (!in_array($class, class_implements($namespace))) return false;
        }
        return true;
    }
}