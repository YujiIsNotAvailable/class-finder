<?php
namespace ClassFinder;

use ClassFinder\Structs;

class PathFinder
{
    use FinderTrait {
        FinderTrait::__construct as protected finderTraitConstruct;
    }

    private string $path;

    private function getFiles(): Structs\FileCollection
    {
        return (new DirFinder($this->path))->getfiles();
    }

    public function __construct(string $basePath, string $path)
    {
        $this->basePath = $basePath;
        $this->path = $path;
        $this->finderTraitConstruct();
    }

    public function get(): Structs\ClassCollection
    {
        return $this->getFiles()->toClassCollection()->filter($this->filters);
    }

}