<?php
namespace ClassFinder;

class Finder
{
    static public function findClassesByNamespace(string $namespace)
    {
        return new NamespaceFinder($namespace);
    }

    static public function findClassesByPath(string $path)
    {
        
    }


}