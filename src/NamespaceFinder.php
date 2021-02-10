<?php
namespace ClassFinder;

class NamespaceFinder
{
    use FinderTrait {
        FinderTrait::__construct as protected finderTraitConstruct;
    }

    private string $namespace;

    private function getFiles(): FileCollection
    {
        // pass by all files in namespace and return
        return DirFinder::fromNamespace($this->basePath, $this->namespace)->getFiles();
    }

    public function __construct(string $basePath, string $namespace)
    {
        $this->namespace = $namespace;
        $this->basePath = $basePath;
        $this->finderTraitConstruct();
    }

    public function get(): ClassCollection
    {
        return $this->getFiles()->toClassCollection()->filter($this->filters);
    }

}