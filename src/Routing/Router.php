<?php

namespace Site\Routing;

use RuntimeException;

class Router
{
    public function get(string $route, callable|array|string $handler): void
    {
        $this->match('GET', $route, $handler);
    }

    public function post(string $route, callable|array|string $handler): void
    {
        $this->match('POST', $route, $handler);
    }

    private function match(string $method, string $route, callable|array|string $handler): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            return;
        }

        $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        $requestPath = '/' . trim($requestPath, '/');
        $route = '/' . trim($route, '/');

        if ($requestPath === '//') {
            $requestPath = '/';
        }

        if ($route === '//') {
            $route = '/';
        }

        $paramNames = [];

        $pattern = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            function (array $matches) use (&$paramNames): string {
                $paramNames[] = $matches[1];

                return '([^/]+)';
            },
            $route
        );

        $pattern = '#^' . $pattern . '$#';

        if (!preg_match($pattern, $requestPath, $matches)) {
            return;
        }

        array_shift($matches);

        $params = [];

        foreach ($paramNames as $index => $name) {
            $params[$name] = $matches[$index] ?? null;
        }

        $this->dispatch($handler, $params);
    }

    private function dispatch(callable|array|string $handler, array $params = []): void
    {
        if (is_array($handler)) {
            [$controller, $method] = $handler;

            $controller->$method($params);
            exit;
        }

        if (is_callable($handler)) {
            $handler($params);
            exit;
        }

        if (is_string($handler)) {
            $path = VIEW_PATH . '/' . ltrim($handler, '/');

            if (!file_exists($path)) {
                throw new RuntimeException("View not found: {$path}");
            }

            require $path;
            exit;
        }

        throw new RuntimeException('Invalid route handler.');
    }

    public function notFound(string $view): void
    {
        http_response_code(404);

        $this->dispatch($view);
    }

    public function redirect(string $route): void
    {
        header('Location: ' . $route);
        exit;
    }

    public function refresh(): void
    {
        header('Location: ' . ($_SERVER['REQUEST_URI'] ?? '/'));
        exit;
    }
}