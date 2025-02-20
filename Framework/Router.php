<?php

declare(strict_types=1);

namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorization;

class Router extends Authorization
{
    private $routes = [];

    private function createRoute(string $method, string $uri, string $controller, string $controllerMethod, array $roles = []): void
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'roles' => $roles
        ];
    }

    public function get(string $uri, string $controller, string $controllerMethod, array $roles = []): void
    {
        $this->createRoute("GET", $uri, $controller, $controllerMethod, $roles);
    }

    public function post(string $uri, string $controller, string $controllerMethod, array $roles = []): void
    {
        $this->createRoute("POST", $uri, $controller, $controllerMethod, $roles);
    }

    public function put(string $uri, string $controller, string $controllerMethod, array $roles = []): void
    {
        $this->createRoute("PUT", $uri, $controller, $controllerMethod, $roles);
    }

    public function delete(string $uri, string $controller, string $controllerMethod, array $roles = []): void
    {
        $this->createRoute("DELETE", $uri, $controller, $controllerMethod, $roles);
    }

    public function route(string $uri, string $method): void
    {
        if($method == "POST" && isset($_POST['_method'])){
            $method = strtoupper($_POST['_method']);
        }

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
                    // check user if user is logged in and check user role (check if user has authorization)
                    $this->isAuthorized($route['roles']);

                    (string) $requestedController = 'App\\controllers\\' . $route['controller'];
                    (string) $requestedControllerMethod = $route['controllerMethod'];

                    $instantiatedController = new $requestedController();
                    $instantiatedController->$requestedControllerMethod($params);

                    return;
                }
            }
        }

        ErrorController::notFound();
    }
}
