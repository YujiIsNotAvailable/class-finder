<?php
namespace ClassFinder;

class File
{
    /** Caminho abstrato */
    private string $path;
    public function __construct(string $path)
    {
        if (!is_file($path)) throw new \InvalidArgumentException("Path $path is not a file.");
        
        $this->path = $path;
    }

    public function getNamespace(): string
    {
        $fileTokens = token_get_all(file_get_contents($this->path));
        $nsTokensKeys = \array_search(\T_NAMESPACE, array_map(
            fn($data) => $data[0], 
            $fileTokens
        ));

        $nsTokens = array_values(array_map(function($arr) {
            return $arr[1];
        }, array_filter(
            array_map(
                fn($data) => $data[2] == $fileTokens[$nsTokensKeys][2] ? $data : null,
                $fileTokens
            )
        )));
        
        return trim(implode(array_splice($nsTokens, 2, count($nsTokens))));
    }

    public function getClass(): string
    {
        $fileTokens = token_get_all(file_get_contents($this->path));
        $classTokensKey = \array_search(\T_CLASS, array_map(
            fn($data) => $data[0], 
            $fileTokens
        ));

        $classTokens = array_values(array_map(function($arr) {
            return $arr[1];
        }, array_filter(
            array_map(
                fn($data) => $data[2] == $fileTokens[$classTokensKey][2] ? $data : null,
                $fileTokens
            )
        )));

        return $classTokens[2];
    }

    public function getFullyQualifiedName(): string
    {
        return $this->getNamespace().$this->getClass();
    }
}