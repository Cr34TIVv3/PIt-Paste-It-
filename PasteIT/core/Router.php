<?php

namespace core;

use controllers\DeleteController;
use controllers\HomeController;
use controllers\PasswordController;
use controllers\PreviewController;
use controllers\UpdateController;
use core\exception\ForbiddenException;
use core\exception\NotFoundException;
use core\exception\BadRequest;
use core\PathValidator;

use models\Paste;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    protected array $smartRoutes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($route, $callback, $is_smart = false)
    {
        if ($is_smart) {
            array_push($this->smartRoutes, $route);
        }
        $this->routes['get'][$route] = $callback;
    }

    public function post($route, $callback, $is_smart = false)
    {
        if ($is_smart) {
            array_push($this->smartRoutes, $route);
        }
        $this->routes['post'][$route] = $callback;
    }

    private function escapingSpecialChars($text)
    {
        $array = array();
        $index = 0;
        for ($i = 0; $i < strlen($text); $i++) {
            if (strstr($text[$i], '/') != false) {
                $array[$index++] = '\\';
            }
            $array[$index++] = $text[$i];
        }
        $output = implode("", $array);
        return $output;
    }

    private function formatRegex($text)
    {
        $text = $this->escapingSpecialChars($text);
        $text = '/^' . $text . '$/';
        return $text;
    }

    private function getCallback()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback == false) {
            $routes = array_keys($this->routes[$method]);

            foreach ($routes as $route) {
                $regex = $this->formatRegex($route);
                if (preg_match($regex, $path)) {
                    return $this->routes[$method][$route];
                }
            }
        } else {
            return $callback;
        }

        $this->response->setStatusCode(404);
        throw new NotFoundException();
    }

    public function isSmart($path)
    {
        foreach ($this->smartRoutes as $route) {
            $regex = $this->formatRegex($route);
            if (preg_match($regex, $path)) {
                return true;
            }
        }

        return false;
    }

    public function resolve()
    {
        $route = $this->request->getPath();

        $callback = $this->getCallback();

        $additional_data = null;

        if ($this->isSmart($route)) {
            $matches = array();
            preg_match('/[0-9a-z]{40}/i',$route, $matches);
            $slug = $matches[0];

            $recordPastes = Paste::findOneImproved('pastes', ['slug' => $slug]);
            $recordVersions = Paste::findVersionDetalied($slug);

            // echo "<pre>";
            // var_dump($recordPastes);
            // var_dump($recordVersions);
            // echo "</pre>";
            // exit;

            if (!$recordPastes === false && !is_null($recordPastes->content)) {
                Application::$app->isVersion = false;
                $additional_data = $recordPastes;
            } else if (!is_null($recordVersions->content)) {
                Application::$app->isVersion = true;
                $additional_data = $recordVersions;
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
        return call_user_func($callback, $this->request, $this->response, $additional_data);
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
