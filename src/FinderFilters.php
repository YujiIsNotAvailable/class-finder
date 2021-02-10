<?php
namespace ClassFinder;

use ClassFinder\Filters;
class FinderFilters
{
    private ?Filters\ShouldImplements $implements;
    
    private ?Filters\ShouldExtends $extends;
    
    private ?Filters\Callback $callback;

    public function __construct()
    {
    }

    public function implements(array $interfaces = []): self
    {
        $this->implements = new Filters\ShouldImplements($interfaces);
        return $this;
    }

    public function extends(array $interfaces = []): self
    {
        $this->extends = new Filters\ShouldExtends($interfaces);
        return $this;
    }

    public function when(\Closure $callback)
    {
        $this->callback = new Filters\Callback($callback);
        return $this;
    }

    public function apply(ClassCollection $classes): ClassCollection
    {
        foreach ($classes as $class) {
            if (isset($this->extends) && !$this->extends->check($class)) {
                $classes->delete($class);
                continue;
            }

            if (isset($this->implements) && !$this->implements->check($class)) {
                $classes->delete($class);
                continue;
            }

            if (isset($this->callback) && !$this->callback->check($class)) {
                $classes->delete($class);
                continue;
            }
        }
        return $classes;
    }

    public function clear()
    {
        $this->implements = null;
        $this->extends = null;
    }
}