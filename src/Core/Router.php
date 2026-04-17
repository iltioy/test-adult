<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $pattern, string $controller, string $action): void
    {
        $this->routes[] = compact('method', 'pattern', 'controller', 'action');
    }

    public function dispatch(string $method, string $uri): bool
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = rtrim($path, '/') ?: '/';

        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            $regex = '#^' . preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route['pattern']) . '$#u';

            if (preg_match($regex, $path, $matches)) {
                $params     = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $controller = new $route['controller']();
                $controller->{$route['action']}($params);
                return true;
            }
        }

        return false;
    }
}
