<?php

namespace Src;

class Router
{
    private static array $routes = [
        "get" => [],
        "post" => []
    ];

    public static function getPath(): string
    {
        return parse_url($_SERVER["REQUEST_URI"])["path"];
    }

    public static function getMethod(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }
    
    /**
     * @param callable(): mixed $handler
     */
    public static function get(string $path, callable $handler): void
    {
        Router::$routes["get"][$path] = $handler;
    }
    
    /**
     * @param callable(): mixed $handler
     */
    public static function post(string $path, callable $handler): void
    {
        Router::$routes["post"][$path] = $handler;
    }

    public static function run(): void
    {
        $handler = Router::$routes[Router::getMethod()][Router::getPath()] ?? null;
        if (is_callable($handler)) {
            $handler();
        }
    }
}