<?php
namespace ClassFinder\Filters;

interface IFilter
{
    public function check(string $namespace): bool;
}