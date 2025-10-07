<?php

namespace Core;

use Closure;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use PHPMailer\PHPMailer\Exception;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Http\Controllers\Errors\MethodNotAllowedController;
use Http\Controllers\Errors\NotFoundController;
use Http\Middleware\Middleware;
use function FastRoute\simpleDispatcher;

class Router
{
    private array $routes;
    private array $group;
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function group(string $prefix, Closure $callback): void
    {
        $this->group[$prefix] = $callback;
    }

    public function add(string $requestMethod, string $uri, array|Closure $controller, array $middleware = []): void
    {
        $this->routes[] = [$requestMethod, $uri, $controller, $middleware];
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $r) {

            if (!empty($this->group)) {
                $this->groupRoutes($r);
            }

            foreach ($this->routes as $route) {
                $r->addRoute(...$route);
            }
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $uri = $uri !== '/' ? rtrim($uri, '/') : $uri;


        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        $this->validatedMiddleware($uri);

        try {
            $this->handler($routeInfo);
        } catch (DependencyException|NotFoundException|Exception $e) {

        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException|Exception
     */
    private function handler(array $routeInfo): void
    {
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:

                $controller = NotFoundController::class;
                $method = 'index';
                $vars = [];
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:

                $controller = MethodNotAllowedController::class;
                $method = 'index';
                $vars = [];
                break;

            case Dispatcher::FOUND:

                [, $controller, $vars] = $routeInfo;

                if (is_callable($controller)) {
                    $method = null;
                }

                if (is_array($controller)) {
                    [$controller, $method] = $controller;
                }
                break;
        }

        /** @var Closure|string $controller */
        /** @var ?string $method */
        /** @var array $vars */
        $this->send($controller, $method, $vars);
    }

    /**
     * @param RouteCollector $r
     * @return void
     */
    function groupRoutes(RouteCollector $r): void
    {
        foreach ($this->group as $prefix => $routes) {
            $r->addGroup($prefix, function (RouteCollector $r) use ($routes) {
                foreach ($routes() as $route) {
                    $r->addRoute(...$route);
                }
            });
        }
    }

    /**
     * @param string $uri
     * @return void
     * @throws Exception
     */
    public function validatedMiddleware(string $uri): void
    {
        foreach ($this->routes as $route) {
            if ($uri === $route[1] && !empty($route[3])) {
                foreach ($route[3] as $key) {
                    Middleware::resolve($key);
                }
            }
        }
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     */
    private function send(Closure|string $controller, ?string $method, array $vars): void
    {
        if (is_callable($controller) && is_null($method)) {
            call_user_func_array($controller, $vars);
            return;
        }
        $controller = $this->container->get($controller);
        $response = call_user_func([$controller, $method], $vars);
        $controller_namespace = get_class($controller);

        if (!$response instanceof Response) {
            throw new Exception("Response not found in $controller_namespace controller and $method method");
        }

        $response->send();
    }
}