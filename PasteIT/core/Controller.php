<?php


namespace core;

use core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout = 'general';

    public string $action = '';
    protected array $middlewares = [];

    public function render($view, $params = [])
    {
        if (strcmp($view, "facing") == 0) {
            $this->layout = 'facing';
        }
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }

    public function setMiddlewares(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }
}
