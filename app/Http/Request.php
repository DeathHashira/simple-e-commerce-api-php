<?php

namespace App\Http;

class Request
{
    private string $method;
    private string $path;
    
    /**
     * @param array<int,mixed> $getParams
     * @param array<int,mixed> $postParams
     * @param array<int,mixed> $server
     */
    public function __construct(
        private array $getParams,
        private array $postParams,
        private array $server
    ) {
        $this->method = strtolower($this->server["REQUEST_METHOD"]);
        $this->path = parse_url($this->server["REQUEST_URI"])["path"];
    }

    public static function createFromGlobal(): self
    {
        return new self($_GET, $_POST, $_SERVER);
    }
    
    public function getBody(): array
    {
        return $this->getParams;
    }
    
    public function postBody(): array
    {
        return $this->postParams;
    }
}