<?php
namespace ClassFinder;

class Finder
{
    static public function findClassesByNamespace(string $basePath, string $namespace)
    {
        return new NamespaceFinder($basePath, $namespace);
    }

    static public function findClassesByPath(string $path)
    {
        
    }


}