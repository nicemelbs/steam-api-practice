<?php

namespace app\core;

use app\core\exceptions\NotFoundException;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;

    }

    /**
     * @throws NotFoundException
     */
    public function resolve()
    {
        //determine the URL path and method
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            $callback = $this->getCallback();

            if ($callback === false) {
                throw new NotFoundException();
            }
        }

        if (is_string($callback)) {
            return Application::$app - view > renderView($callback);
        }

        if (is_array($callback)) {
            /**
             * @var Controller $controller
             */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }

        }

        return call_user_func($callback, $this->request, $this->response);
    }


    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    private function getCallback()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getPath();
        $url = trim($url, '/');

        //Get all routes for the current request method
        $routes = $this->routes[$method] ?? [];

        $routeParams = false;

        // start iterating registered routes
        foreach ($routes as $route => $callback) {
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            // create route name into regex pattern
            // @^ ... some regex .. $@ .... @ instead of '/' for slightly better readability
            // this string should evaluate to something like
            // "@^profile/(\w+)$@"
            // "@^profile/(\d+)/(\w+)$@"
            $routeRegex = "@^" .
                preg_replace_callback('/\{\w+(:([^}]+))?}/',
                    function ($matches) {
                        if (isset($matches[2])) {
                            return "({$matches[2]})";
                        } else return "(\w+)";
                    },
                    $route
                ) .
                "$@";

            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }

                $routeParams = array_combine($routeNames, $values);
                $this->request->setRouteParams($routeParams);

                return $callback;
            }

        }
        return false;
    }
}