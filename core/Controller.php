<?php

namespace app\core;

use app\core\middleware\BaseMiddleware;

class Controller
{
    public string $layout = 'main';

    /**
     * @var BaseMiddleware[]
     */
    public array $middlewares = [];

    /**
     * @return BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    /**
     * @param BaseMiddleware[] $middlewares
     */
    public function setMiddlewares(array $middlewares): void
    {
        $this->middlewares = $middlewares;
    }

    public string $action = '';

    /**
     * @var string[]
     */
    public array $actions = [];

    //GET: /users
    //route: users.index
    public function index()
    {

    }

    //GET: /users/create
    //route: users.create
    public function create()
    {

    }

    //POST: /users
    //route: users.store
    public function store()
    {

    }

    //GET: /users/{userId}
    //route: users.show
    public function show()
    {

    }

    //PUT/PATCH: /users/{userId}
    //route: users.update
    public function update()
    {

    }

    //DELETE: /users/{userId}
    //route: users.destroy
    public function destroy()
    {

    }

    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    /**
     * @return string
     */
    public function getLayout(): string
    {
        return $this->layout;
    }

    /**
     * @param string $layout
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    public function registerMiddleware(Basemiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }
}