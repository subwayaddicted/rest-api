<?php

namespace Core\Routing;


class Router
{
    public $routes;

    // Constructor getting routes
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    // Pattern matching
    public function resolve($app_path)
    {
        $matched = false;

        // Searching for path
        foreach ($this->routes as $route)
        {
            if (strpos($app_path, $route->pattern) === 0)
            {
                $matched = true;
                break;
            }
        }

        if (! $matched) throw new \Exception('Could not match route.');

        // Parametrs(?)
        $param_str = str_replace($route->pattern, '', $app_path);
        $params = explode('/', trim($param_str, '/'));
        $params = array_filter($params);

        $match = clone($route);
        $match->params = $params;

        return $match;
    }
}