<?php

namespace App\Routing;

use App\Http\Request;
use BadMethodCallException;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;

class Router
{
    private static array $instances = [];
    private array $routes = [];

    private array $methods = ["GET", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"];

    public static function getInstance(): Router
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function get(string $uri, mixed $action): void
    {
        $route = $this->createRoute('GET', $uri, $action);

        $this->routes[] = $route;
    }

    public function post(string $uri, mixed $action): void
    {
        $route = $this->createRoute('POST', $uri, $action);

        $this->routes[] = $route;
    }

    public function put(string $uri, mixed $action): void
    {
        $route = $this->createRoute('PUT', $uri, $action);

        $this->routes[] = $route;
    }

    public function delete(string $uri, mixed $action): void
    {
        $route = $this->createRoute('DELETE', $uri, $action);

        $this->routes[] = $route;
    }

    private function createRoute(string $method, string $uri, mixed $action): Route
    {
        return new Route($uri, $method, $action);
    }

    public function routing(): void
    {
        $uri = (string)parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = trim($uri, "/");
        $route = array_filter($this->routes, fn($route) => $route->getUri() === $uri && $route->getMethod() === $method);

        if (empty($route)) {
            $this->abort();
        }

        $route = array_shift($route);

        $action = $route->getAction();

        if ($this->isControllerAction($action)) {
            $this->runController($action);
        }

        if (is_callable($action)) {
            call_user_func($action);
            die();
        }
    }

    public function isControllerAction(mixed $action): bool
    {
        return is_array($action) && is_string($action[0]) && !is_callable($action[0]);
    }

    public function runController(array $action): void
    {
        [$controllerClass, $method] = $action;

        $reflection = new ReflectionClass($controllerClass);

        if (!$reflection->isInstantiable()) {
            throw new InvalidArgumentException("Class ({$controllerClass}) not instantiable.");
        }

        $controller = $reflection->newInstance();

        if (!method_exists($controller, $method)) {
            throw new BadMethodCallException("Method ({$method}) not exist in class/object $controller.");
        }

        $request = new Request();
        call_user_func([$controller, $method], $request);

        die();
    }

    public function abort(int $statusCode = 404)
    {
        http_response_code($statusCode);
        die("Not Found");
    }
}
