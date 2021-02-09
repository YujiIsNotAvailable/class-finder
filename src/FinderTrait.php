<?php
namespace ClassFinder;

trait FinderTrait
{
    private FinderFilters $filters;
    
    public function __construct()
    {
        $this->filters = new FinderFilters();
    }
    
    public function implements($interfaces): self
    {
        if (is_string($interfaces)) $interfaces = [ $interfaces ];
        elseif (is_array($interfaces));
        else throw new \InvalidArgumentException("Expected string or array parameter");
        
        $this->filters->implements($interfaces);
        return $this;
    }
    
    public function extends($classes): self
    {
        if (is_string($classes)) $classes = [ $classes ];
        elseif (is_array($classes));
        else throw new \InvalidArgumentException("Expected string or array parameter");

        $this->filters->extends($classes);
        return $this;
    }
}