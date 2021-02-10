<?php
namespace ClassFinder\Filters;

use ClassFinder\Filters\IFilter;

class Callback implements IFilter
{
    private \Closure $callback;
    /**
     * Expect an callback with boolean return;
     * @param \Closure $callback
     */
    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Run a callback, expecting boolean return
     * @param string $namespace
     * @return boolean
     */
    public function check(string $namespace): bool
    {
        return \call_user_func($this->callback, $namespace);
    }
}
