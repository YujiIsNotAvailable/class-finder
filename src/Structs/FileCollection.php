<?php
namespace ClassFinder\Structs;

class FileCollection implements \IteratorAggregate
{
    private array $files = [];

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->files);
    }

    public function add(File $path): self
    {
        $this->files[] = $path;
        return $this;
    }

    public function delete(File $path): self
    {
        $key = array_search($path, $this->files);
        if ($key) unset($this->files[$key]);
        return $this;
    }

    public function toClassCollection(): ClassCollection
    {
        return new ClassCollection(array_filter(array_map(function(File $file) {
            if ($file->isClass()) return $file->getFullyQualifiedName();
        }, $this->files)));
    }
}