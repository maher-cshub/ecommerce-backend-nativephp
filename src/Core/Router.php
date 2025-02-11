<?php
namespace App\Core;

class Router {
    private array $routes = [];

    // Register a GET route
    public function get(string $uri, $action): void {
        $this->routes['GET'][$this->normalizeUri($uri)] = $action;
    }

    // Register a POST route (extendable for PUT, DELETE, etc.)
    public function post(string $uri, $action): void {
        $this->routes['POST'][$this->normalizeUri($uri)] = $action;
    }

    // Dispatch the request to the correct route
    public function dispatch(string $method, string $uri): void {
        // Normalize the URI (remove trailing slashes, etc.)
        $uri = $this->normalizeUri(parse_url($uri, PHP_URL_PATH));

        if (isset($this->routes[$method][$uri])) {
            $action = $this->routes[$method][$uri];

            // If the action is a callable, execute it directly
            if (is_callable($action)) {
                call_user_func($action);
            }
            // If the action is a string, treat it as a controller@method call
            elseif (is_string($action)) {
                $this->callController($action);
            }
            return;
        }

        // If no route matches, return a 404 response
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }

    // Normalize the URI to ensure consistent matching
    private function normalizeUri(string $uri): string {
        return rtrim($uri, '/') ?: '/';
    }

    // Call a controller action defined as a string "ControllerClass@method"
    private function callController(string $action): void {
        list($controller, $method) = explode('@', $action);

        if (class_exists($controller)) {
            $controllerInstance = new $controller;
            if (method_exists($controllerInstance, $method)) {
                call_user_func([$controllerInstance, $method]);
                return;
            }
        }

        // Return a 500 error if the controller or method is not found
        http_response_code(500);
        echo json_encode(['error' => 'Controller or method not found']);
    }
}
