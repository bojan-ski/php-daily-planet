<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    protected $routes = [];

    private function createRoute(string $method, string $uri, string $controller, string $controllerMethod): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    public function get(string $uri, string $controller, string $controllerMethod): void
    {
        $this->createRoute("GET", $uri, $controller, $controllerMethod);
    }

    public function post(string $uri, string $controller, string $controllerMethod): void
    {
        $this->createRoute("POST", $uri, $controller, $controllerMethod);
    }

    public function put(string $uri, string $controller, string $controllerMethod): void
    {
        $this->createRoute("PUT", $uri, $controller, $controllerMethod);
    }

    public function delete(string $uri, string $controller, string $controllerMethod): void
    {
        $this->createRoute("DELETE", $uri, $controller, $controllerMethod);
    }

    public function route(string $uri, string $method): void
    {
        // inspect($uri);
        // inspect($method);
        // inspectAndDie($this->routes);

        foreach ($this->routes as $route) {
            // inspectAndDie($route);

            if ($route['uri'] == $uri && $route['method'] == $method) {
                (string) $requestedController = 'App\\controllers\\' . $route['controller'];
                (string) $requestedControllerMethod = $route['controllerMethod'];

                $instantiatedController = new $requestedController();
                $instantiatedController->$requestedControllerMethod();
            }
        }
    }
}
