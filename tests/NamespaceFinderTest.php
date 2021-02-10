<?php
namespace ClassFinder\Tests;

use ClassFinder\Filters\IFilter;
use ClassFinder\Finder;
use ClassFinder\Structs\ClassCollection;
use PHPUnit\Framework\TestCase;

class NamespaceFinderTest extends TestCase
{
    private string $basePath;
    public function __construct(...$args)
    {
        $this->basePath = dirname(__DIR__, 1);
        parent::__construct(...$args);
    }

    public function testFindClassInSrcNamespaceFilteringImplementsAndExtends()
    {
        $this->assertEquals(
            new ClassCollection([
                "ClassFinder\Filters\Callback",
                "ClassFinder\Filters\ShouldExtends",
                "ClassFinder\Filters\ShouldImplements",
            ]), 
            Finder::findClassesInNamespace($this->basePath, "ClassFinder\Filters")
                ->implements(IFilter::class)
                ->get()
        );
    }

    public function testFindClassInSrcNamespaceWithWhereFilter()
    {
        $this->assertEquals(
            new ClassCollection([
                "ClassFinder\Structs\ClassCollection",
                "ClassFinder\Structs\FileCollection",
            ]), 
            Finder::findClassesInNamespace($this->basePath, 'ClassFinder\\Structs')
                ->where(fn(string $namespace) => strlen($namespace) > 24)
                ->get()
        );
    }
}