<?php

namespace Src;

use App\Http\Request;

class Router
{
    private static array $routes = [
        "get" => [],
        "post" => []
    ];
    /**
     * @param callable(): mixed $handler
     */
    private static function add(string $method, string $path, callable $handler, string $middleware=""): void
    {
       Router::$routes[$method][$path] = [$handler, $middleware];
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
    public static function get(string $path, callable $handler, string $middleware=""): void
    {
        Router::add("get", $path, $handler, $middleware);
    }

    /**
     * @param callable(): mixed $handler
     */
    public static function post(string $path, callable $handler, string $middleware=""): void
    {
        Router::add("post", $path, $handler, $middleware);
    }

    public static function run(Request $request): void
    {
        [$handler, $middleware] = Router::$routes[Router::getMethod()][Router::getPath()];
        if (!empty($middleware)) {
            $mvHandler = MiddlewareRegistry::resolve($middleware);
            if (is_callable($handler)) {
                $mvHandler($request, $handler);
            }
        } else {
            if (is_callable($handler)) {
                $handler();
            }
        }
    }
}
