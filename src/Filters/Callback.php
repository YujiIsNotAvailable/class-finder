<?php
namespace ClassFinder\Filters;

use ClassFinder\Filters\IFilter;

class Callback implements IFilter
{
    private \Closure $callback;
    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
    }

    public function check(string $namespace): bool
    {
        return \call_user_func($this->callback, $namespace);
    }
}
