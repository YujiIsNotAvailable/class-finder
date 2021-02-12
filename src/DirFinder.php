<?php
namespace ClassFinder;
use ClassFinder\Structs;

class DirFinder
{
    use FinderTrait;
    private string $dir;

    public function __construct(string $dir)
    {
        if (!is_dir($dir)) throw new Exceptions\InvalidPath("'{$dir}' is not a valid directory path.");
        $this->dir = $dir;
    }

    public function getFiles(): Structs\FileCollection
    {
        $dirContent = scandir($this->dir);
        $collection = new Structs\FileCollection();
        array_map(function(string $_path) use($collection) {
            $path = $this->dir.DIRECTORY_SEPARATOR.$_path;
            if (is_file($path)) $collection->add(new Structs\File($path));
        }, $dirContent);
        return $collection;
    }

    public function get()
    {
        return $this;
    }

    static public function fromNamespace(string $basePath, string $namespace): self
    {
        $_composerJsonPath = $basePath.DIRECTORY_SEPARATOR.'composer.json';
        if (!is_file($_composerJsonPath)) throw new Exceptions\InvalidPath("'{$_composerJsonPath}' is not a valid file path.");

        $composerJson = json_decode(file_get_contents($_composerJsonPath));
        if (!$composerJson) throw new Exceptions\InvalidPath("File '{$_composerJsonPath}' not found.");
        $classes = (array)$composerJson->autoload->{'psr-4'};

        $namespaceExploded = explode("\\", $namespace);
        $namespacePiecesLength = count($namespaceExploded);

        $_index = 0;
        $base = $namespaceExploded[$_index]."\\";
        unset($namespaceExploded[$_index]);

        $baseDir = $classes[$base] ?? null;
        if (!$baseDir) throw new Exceptions\InvalidNamespace("Namespace '{$base}' not loaded on {$_composerJsonPath}");

        $path = $basePath.DIRECTORY_SEPARATOR.$baseDir;
        do {
            $path .= DIRECTORY_SEPARATOR.$namespaceExploded[++$_index];
            unset($namespaceExploded[$_index]);
        } while ($namespaceExploded);
        return new self($path);
    }
}
