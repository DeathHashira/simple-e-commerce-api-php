<?php

namespace App\Http;

class Response
{
    public function __construct(
        private int $statusCode = 200,
        private array $headers = [],
        private mixed $content
    ) {}

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getContent(): mixed
    {
        return $this->content;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function setHeader(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    public function setContent(mixed $body): void
    {
        $this->content = $body;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;
    }
}