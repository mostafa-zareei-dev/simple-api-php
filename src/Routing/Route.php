<?php

namespace App\Routing;

use InvalidArgumentException;

class Route
{
    private string $uri;
    private string $method;
    private mixed $action;

    private static Router $router;

    public function __construct(string $uri, string $method, mixed $action)
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->action = $action;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getAction(): mixed
    {
        return $this->action;
    }

    public static function __callStatic($method, $arguments)
    {
        $method = strtoupper(trim($method));

        self::$router = Router::getInstance();

        if (!in_array($method, self::$router->getMethods())) {
            throw new InvalidArgumentException("parameter method: $method not allowed.");
            exit;
        }

        [$uri, $action] = $arguments;

        $uri = trim($uri, "/");
        $method = strtolower($method);

        call_user_func([self::$router, $method], $uri, $action);
    }
}
