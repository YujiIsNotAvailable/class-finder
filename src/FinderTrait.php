<?php
namespace ClassFinder;

trait FinderTrait
{
    private FinderFilters $filters;
    
    public function __construct()
    {
        $this->filters = new FinderFilters();
    }
    
    /**
     * Add filter of 'class implements' on finder.
     * @param array|string $interfaces
     * @return static
     */
    public function implements($interfaces): self
    {
        if (is_string($interfaces)) $interfaces = [ $interfaces ];
        elseif (is_array($interfaces));
        else throw new \InvalidArgumentException("Expected string or array parameter");

        $this->filters->implements($interfaces);
        return $this;
    }
    
    /**
     * Add filter of 'class extends' on finder.
     * @param array|string $classes
     * @return static
     */
    public function extends($classes): self
    {
        if (is_string($classes)) $classes = [ $classes ];
        elseif (is_array($classes));
        else throw new \InvalidArgumentException("Expected string or array parameter");

        $this->filters->extends($classes);
        return $this;
    }

    /**
     * Add filter callback on filter
     * @param \Closure $callback
     * @return static
     */
    public function where(\Closure $callback): self
    {
        $this->filters->where($callback);
        return $this;
    }
}