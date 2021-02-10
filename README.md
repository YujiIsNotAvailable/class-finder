# ClassFinder #

## For what? ##
Do you need get classes from specific namespace in a easy way? :rocket: <br />
Check this package.

## Requirements ##
- Using composer (Needed for search in autoload composer.json)
- PSR-4 implementations
- PHP 7.3 >=

## Instalation ##
```
composer require yj-php-utils-class-finder
```

## Usage ##
```php
// Your basePath project. 
$basePath = defined('BASE_PATH') ? BASEPATH : '/var/www/html/your_project_base_path';

// List all classes in App\Http\Controllers namespace
$classes = \ClassFinder\Finder::findClassesInNamespace($basePath, 'App\Http\Controllers')->get();

// List all classes in '.' directory
$classes = \ClassFinder\Finder::findClassesInPath($basePath, __DIR__)->get();

// With filters
$classes = 
    \ClassFinder\Finder::findClassesInNamespace($basePath, 'App\Http\Controllers')
    ->extends('\App\Http\Controllers\Controller')
    ->implements('\App\Http\Controllers\ApiInterface')
    ->where(function(string $namespace){ // get all classes that has index() method
        return method_exists($namespace, 'index');
    })
    ->get();
```