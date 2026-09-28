<?php

namespace Src;

class Router
{
    private static array $routes = [
        "get" => [],
        "post" => []
    ];

    private static function add(string $method, string $path, callable $handler, string $middleware=""): self
    {
        Router::$routes[$method][$path] = [$handler, $middleware];
        return $this;
    }

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
    public static function get(string $path, callable $handler, string $middleware=""): self
    {
        return Router::add("get", $path, $handler, $middleware);
    }

    /**
     * @param callable(): mixed $handler
     */
    public static function post(string $path, callable $handler, string $middleware=""): self
    {
        return Router::add("post", $path, $handler, $middleware);
    }

    public static function run(): void
    {
        [$handler, $middleware] = Router::$routes[Router::getMethod()][Router::getPath()];
        if (!empty($middleware)) {
            $mvHandler = MiddlewareRegistry::resolve($middleware);
            mvHandler();
        }
        if (is_callable($handler)) {
            $handler();
        }
    }
}
