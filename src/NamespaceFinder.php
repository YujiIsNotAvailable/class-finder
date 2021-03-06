<?php
namespace ClassFinder;

use ClassFinder\Structs;

class NamespaceFinder
{
    use FinderTrait {
        FinderTrait::__construct as protected finderTraitConstruct;
    }

    private string $namespace;

    private function getFiles(): Structs\FileCollection
    {
        return DirFinder::fromNamespace($this->basePath, $this->namespace)->getFiles();
    }

    public function __construct(string $basePath, string $namespace)
    {
        $this->basePath = $basePath;
        $this->namespace = $namespace;
        $this->finderTraitConstruct();
    }

    public function get(): Structs\ClassCollection
    {
        return $this->getFiles()->toClassCollection()->filter($this->filters);
    }

}