<?php
namespace ClassFinder\Filters;

class ShouldExtends implements IFilter
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
            if (!is_subclass_of($namespace, $class)) return false;
        }
        return true;
    }
}