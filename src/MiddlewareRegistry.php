<?php

namespace Src;

class MiddlewareRegistry
{
    public static array $middlewares = [];

    public static function resolve(string $name): callable
    {
        return static::$middlewares[$name];
    }

    public static function registerMiddleware(string $name, callable $handler): void
    {
        static::$middlewares[$name] = $handler;
    }
}
