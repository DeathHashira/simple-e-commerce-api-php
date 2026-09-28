<?php

namespace App\Http;

class Request
{
    private string $method;
    private string $path;

    /**
     * @param array<string,string> $getParams
     * @param array<string,string> $postParams
     * @param array<string,string> $server
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

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHeaders(): array
    {
        return getallheaders();
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
