<?php

namespace Site\Routing;

use RuntimeException;
class Router
{
    private array $routes = [];

    private $notFoundHandler = null;

    public function get(string $uri, callable|array|string $handler): void
    {
        $this->add('GET', $uri, $handler);
    }

    public function post(string $uri, callable|array|string $handler): void
    {
        $this->add('POST', $uri, $handler);
    }

    private function add(string $method, string $uri, callable|array|string $handler): void
    {
        $uri = $this->normalizeUri($uri);

        $this->routes[$method][$uri] = $handler;
    }

    public function notFound(callable|array|string $handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        $uri = $this->normalizeUri($uri);

        $handler = $this->routes[$method][$uri] ?? null;

        if ($handler === null) {
            $this->runNotFound();
            return;
        }

        $this->runHandler($handler);
    }

    private function normalizeUri(string $uri): string
    {
        $uri = parse_url($uri, PHP_URL_PATH) ?: '/';

        if ($uri !== '/') {
            $uri = rtrim($uri, '/');
        }

        return $uri;
    }

    private function runHandler(callable|array|string $handler, array $params = []): void
    {
        if (is_array($handler)) {
            [$controller, $method] = $handler;

            $controller->$method(...$params);
            exit;
        }

        if (is_callable($handler)) {
            $handler(...$params);
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

    private function runNotFound(): void
    {
        http_response_code(404);

        if ($this->notFoundHandler !== null) {
            $this->runHandler($this->notFoundHandler);
            return;
        }

        echo '404 Not Found';
        exit;
    }
}