<?php
/**
 * Simple Router Class
 */

class Router {
    private $routes = [];
    private $middlewares = [];
    private $notFoundHandler;
    
    public function __construct() {
        $this->notFoundHandler = function() {
            http_response_code(404);
            echo json_encode(['error' => 'Route not found']);
        };
    }
    
    public function get($path, $handler, $middleware = null) {
        $this->addRoute('GET', $path, $handler, $middleware);
    }
    
    public function post($path, $handler, $middleware = null) {
        $this->addRoute('POST', $path, $handler, $middleware);
    }
    
    public function put($path, $handler, $middleware = null) {
        $this->addRoute('PUT', $path, $handler, $middleware);
    }
    
    public function delete($path, $handler, $middleware = null) {
        $this->addRoute('DELETE', $path, $handler, $middleware);
    }
    
    public function patch($path, $handler, $middleware = null) {
        $this->addRoute('PATCH', $path, $handler, $middleware);
    }
    
    private function addRoute($method, $path, $handler, $middleware = null) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }
    
    public function addMiddleware($middleware) {
        $this->middlewares[] = $middleware;
    }
    
    public function setNotFoundHandler($handler) {
        $this->notFoundHandler = $handler;
    }
    
    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove trailing slash
        $uri = rtrim($uri, '/');
        if (empty($uri)) {
            $uri = '/';
        }
        
        // Run global middlewares
        foreach ($this->middlewares as $middleware) {
            $middleware();
        }
        
        // Find matching route
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $uri)) {
                // Run route-specific middleware
                if ($route['middleware']) {
                    $route['middleware']();
                }
                
                // Extract parameters
                $params = $this->extractParams($route['path'], $uri);
                
                // Execute handler
                if (is_callable($route['handler'])) {
                    return call_user_func_array($route['handler'], $params);
                } else {
                    return $this->callController($route['handler'], $params);
                }
            }
        }
        
        // No route found
        call_user_func($this->notFoundHandler);
    }
    
    private function matchPath($routePath, $uri) {
        $routeRegex = preg_replace('/\{([^}]+)\}/', '([^/]+)', $routePath);
        $routeRegex = '#^' . $routeRegex . '$#';
        return preg_match($routeRegex, $uri);
    }
    
    private function extractParams($routePath, $uri) {
        $params = [];
        $routeParts = explode('/', trim($routePath, '/'));
        $uriParts = explode('/', trim($uri, '/'));
        
        foreach ($routeParts as $index => $part) {
            if (preg_match('/\{([^}]+)\}/', $part, $matches)) {
                $paramName = $matches[1];
                $params[$paramName] = $uriParts[$index] ?? null;
            }
        }
        
        return $params;
    }
    
    private function callController($controllerString, $params) {
        list($controller, $method) = explode('@', $controllerString);
        $controllerClass = $controller . 'Controller';
        
        if (!class_exists($controllerClass)) {
            throw new Exception("Controller $controllerClass not found");
        }
        
        $controllerInstance = new $controllerClass();
        
        if (!method_exists($controllerInstance, $method)) {
            throw new Exception("Method $method not found in controller $controllerClass");
        }
        
        return call_user_func_array([$controllerInstance, $method], $params);
    }
} 