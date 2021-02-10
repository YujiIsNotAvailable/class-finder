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

        array_map(function(string $_path) use($collection) {
            $path = $this->dir.DIRECTORY_SEPARATOR.$_path;
            if (is_file($path)) $collection->add(new File($path));
        }, $dirContent);

        return $collection;
    }

    public function get()
    {
        return $this;
    }

    static public function fromNamespace(string $basePath, string $namespace): self
    {
        $dir = str_replace($namespace, DIRECTORY_SEPARATOR, '\\');
        
        $_composerJsonPath = $basePath.DIRECTORY_SEPARATOR.'composer.json';
        $composerJson = json_decode(file_get_contents($_composerJsonPath));

        if (!$composerJson) throw new \Exception("File {$_composerJsonPath} not found.");
        $classes = (array)$composerJson->autoload->{'psr-4'};

        $namespaceExploded = explode("\\", $namespace);
        $namespacePiecesLength = count($namespaceExploded);

        $_index = 0;
        $base = $namespaceExploded[$_index]."\\";
        unset($namespaceExploded[$_index]);

        $baseDir = $classes[$base] ?? null;
        if (!$baseDir) throw new \Exception("Namespace {$base} not loaded on {$_composerJsonPath}");

        $path = $basePath.DIRECTORY_SEPARATOR.$baseDir;
        do {
            dump($path);
            $path .= DIRECTORY_SEPARATOR.$namespaceExploded[++$_index];
            unset($namespaceExploded[$_index]);
        } while ($namespaceExploded);
        
        return new self($path);
    }
}