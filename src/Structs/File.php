<?php
namespace ClassFinder\Structs;
use ClassFinder\Exceptions;

class File
{
    public const TOKEN_KEY = 0;
    public const TOKEN_DATA = 1;
    public const TOKEN_TYPE_KEY = 2;

    /** Caminho abstrato */
    private string $path;
    public function __construct(string $path)
    {
        if (!is_file($path)) throw new Exceptions\InvalidPath("Path '{$path}' is not a valid file path.");
        $this->path = $path;
    }

    private function getTokenValues(int $token): array
    {
        $fileTokens = token_get_all(file_get_contents($this->path));
        $nsTokensKeys = \array_search($token, array_map(
            fn($data) => $data[self::TOKEN_KEY], 
            $fileTokens
        ));

        return array_values(array_map(function($arr) {
            return $arr[self::TOKEN_DATA];
        }, array_filter(
            array_map(function($data) use($fileTokens, $nsTokensKeys) {
                return isset($data[self::TOKEN_TYPE_KEY]) && ($data[self::TOKEN_TYPE_KEY] == $fileTokens[$nsTokensKeys][self::TOKEN_TYPE_KEY]) ? $data : null;
            },
                $fileTokens
            )
        )));
    }

    public function isClass(): bool
    {
        return isset($this->getTokenValues(T_CLASS)[self::TOKEN_TYPE_KEY]);
    }

    public function getNamespace(): string
    {
        $nsTokens = $this->getTokenValues(T_NAMESPACE);
        return trim(implode(array_splice($nsTokens, self::TOKEN_TYPE_KEY, count($nsTokens))));
    }

    public function getClass(): string
    {
        if (!$this->isClass()) throw new Exceptions\InvalidClass("'{$this->path}' is not a valid file Class");
        return $this->getTokenValues(T_CLASS)[self::TOKEN_TYPE_KEY];
    }

    public function getFullyQualifiedName(): string
    {
        return $this->getNamespace().DIRECTORY_SEPARATOR.$this->getClass();
    }
}
