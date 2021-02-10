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

    private function getTokenValues(int $token): array
    {
        $fileTokens = token_get_all(file_get_contents($this->path));
        $nsTokensKeys = \array_search($token, array_map(
            fn($data) => $data[0], 
            $fileTokens
        ));

        return array_values(array_map(function($arr) {
            return $arr[1];
        }, array_filter(
            array_map(function($data) use($fileTokens, $nsTokensKeys) {
                return isset($data[2]) && ($data[2] == $fileTokens[$nsTokensKeys][2]) ? $data : null;
            },
                $fileTokens
            )
        )));
    }

    public function getNamespace(): string
    {
        $nsTokens = $this->getTokenValues(T_NAMESPACE);
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
            array_map(function($data) use($fileTokens, $classTokensKey) {
                return isset($data[2]) && ($data[2] == $fileTokens[$classTokensKey][2]) ? $data : null;
            },
                $fileTokens
            )
        )));

        return $classTokens[2];
    }

    public function getFullyQualifiedName(): string
    {
        return $this->getNamespace().DIRECTORY_SEPARATOR.$this->getClass();
    }
}