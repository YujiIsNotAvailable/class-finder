<?php
namespace ClassFinder;

class Finder
{
    static public function findClassesInNamespace(string $basePath, string $namespace)
    {
        return new NamespaceFinder($basePath, $namespace);
    }

    static public function findClassesInPath(string $basePath, string $path)
    {
        return new PathFinder($basePath, $path);
    }
}