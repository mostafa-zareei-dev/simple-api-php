<?php

namespace App\Http;

class Request
{
    private array $query = [];
    private array $params = [];
    private array $server = [];
    private array $headers = [];
    private string $method;

    public function __construct()
    {
        $this->query = $_GET;
        $this->params = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $this->server = $_SERVER;
        $this->headers = $this->parseHeaders();
        $this->method = $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    public function query(string $key, $default = null): array | string | null
    {
        return $this->query[$key] ?? $default;
    }

    public function params(): array
    {
        return $this->params;
    }

    public function param(string $key, $default = null): array | string | null
    {
        return $this->params[$key] ?? $default;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function server($key, $default = null): string | null
    {
        return $this->serverParams[$key] ?? $default;
    }


    public function header($key, $default = null): string | null
    {
        $key = strtolower($key);
        return $this->headers[$key] ?? $default;
    }

    private function parseHeaders(): array
    {
        $headers = [];
        foreach ($this->server as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headerName = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $headers[$headerName] = $value;
            }
        }
        return $headers;
    }
}
