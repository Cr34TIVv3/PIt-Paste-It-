<?php

namespace core;

use controllers\HomeController;
use controllers\PreviewController;
use core\exception\ForbiddenException;
use core\exception\NotFoundException;
use core\PathValidator;

use models\Paste;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();

        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            if (PathValidator::validate($path)) {
                // $pos = strrpos($path, "/");
                // $path = substr($path, $pos + 1, strlen($path));
                $path = substr($path, 1);
                $record = Paste::findOne(['slug' => $path]);
                if (!is_null($record->content)) {
                    $preview = new PreviewController();
                    return $preview->handlePreview($this->request, $record);
                } else {
                    $this->response->setStatusCode(404);
                    throw new NotFoundException();
                }
            } else {
                $this->response->setStatusCode(404);
                throw new NotFoundException();
            }
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if (is_array($callback)) {
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

    public function renderView($view, $params = [], $styles = "")
    {
        $layoutContent = $this->layoutContent($view);
        $viewContent = $this->renderOnlyView($view, $params);
        $viewStyle = $this->renderOnlyStyle($view);
        $viewJs = $this->renderOnlyScript($view);
        $layoutContent = str_replace('{{style}}', $viewStyle,  $layoutContent);
        $layoutContent = str_replace('{{script}}', $viewJs,  $layoutContent);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    //good
    protected function layoutContent($view)
    {
        if (!is_null(Application::$app->controller)) {
            $layout = Application::$app->controller->layout;
        } else {
            $layout = 'general';
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }

    protected function renderOnlyStyle($view)
    {
        if (strcmp("/", $view) == 0) {
            return "facing";
        }
        return $view;
    }

    protected function renderOnlyScript($view)
    {
        if (strcmp($view, "facing") == 0) {
            return "chart";
        } else if (strcmp($view, "account") == 0) {
            return "chart&nav";
        } else {
            return "nav";
        }
    }
}
