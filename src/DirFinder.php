<?php
namespace ClassFinder;

class DirFinder
{
    use FinderTrait;
    private string $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function getFiles(): FileCollection
    {
        $dirContent = scandir($this->dir);
        $collection = new FileCollection();
        
        array_map(function(string $path) use($collection) {
            if (is_file($path)) $collection->add(new File($path));
        }, $dirContent);

        return $collection;
    }

    public function get()
    {
        return $this;
    }

    static public function fromNamespace(string $namespace): self
    {
        $dir = str_replace($namespace, DIRECTORY_SEPARATOR, '\\');
        return new self($dir);
    }
}