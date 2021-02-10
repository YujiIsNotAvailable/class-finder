<?php
namespace ClassFinder\Tests;

use ClassFinder\Finder;
use ClassFinder\Structs\ClassCollection;
use PHPUnit\Framework\TestCase;

class PathFinderTest extends TestCase
{
    private string $basePath;
    public function __construct(...$args)
    {
        $this->basePath = dirname(__DIR__, 1);
        parent::__construct(...$args);
    }

    public function testFindClassInSrcPathFiltering()
    {
        $this->assertEquals(
            new ClassCollection([
                "ClassFinder\DirFinder",
                "ClassFinder\Finder",
                "ClassFinder\FinderFilters",
                "ClassFinder\NamespaceFinder",
                "ClassFinder\PathFinder",
            ]), 
            Finder::findClassesInPath($this->basePath, $this->basePath.DIRECTORY_SEPARATOR.'/src')
                ->get()
        );
    }

    public function testFindClassInSrcPathWithWhereFilter()
    {
        $this->assertEquals(
            new ClassCollection([
                "ClassFinder\DirFinder",
                "ClassFinder\FinderFilters",
                "ClassFinder\NamespaceFinder",
                "ClassFinder\PathFinder",
            ]), 
            Finder::findClassesInPath($this->basePath, $this->basePath.DIRECTORY_SEPARATOR.'/src')
                ->where(fn(string $namespace) => strlen($namespace) > 18)
                ->get()
        );
    }
}