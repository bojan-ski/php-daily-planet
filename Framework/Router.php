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
            // inspect($route);

            (bool) $match = true;
            (array) $uriSegments = explode('/', trim($uri, '/'));
            // inspect($uriSegments);
            // inspectAndDie($uriSegments);
            (array) $routeSegments = explode('/', trim($route['uri'], '/'));
            // inspect($routeSegments);

            if (count($uriSegments) == count($routeSegments) && strtoupper($route['method']) == $method) {
                (array) $params = [];

                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    if ($routeSegments[$i] != $uriSegments[$i] && !preg_match('/\{(.+?)\}/', $routeSegments[$i])) {
                        $match = false;
                        break;
                    }

                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                if ($match) {
                    (string) $requestedController = 'App\\controllers\\' . $route['controller'];
                    (string) $requestedControllerMethod = $route['controllerMethod'];

                    $instantiatedController = new $requestedController();
                    $instantiatedController->$requestedControllerMethod($params);

                    return;
                }
            }
        }
    }
}
