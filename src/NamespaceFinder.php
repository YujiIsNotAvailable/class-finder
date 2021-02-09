<?php
namespace ClassFinder;

class NamespaceFinder
{
    use FinderTrait;
    private string $namespace;

    private function getFiles(): FileCollection
    {
        // pass by all files in namespace and return
        return DirFinder::fromNamespace($this->namespace)->getFiles();
    }

    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function get(): ClassCollection
    {
        return $this->getFiles()->toClassCollection()->filter($this->filters);
    }

}