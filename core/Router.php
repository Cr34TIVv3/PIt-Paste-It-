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

            if (PathValidator::validatePasswordRequest($path)) {
 
                $path = substr($path, 1, -9);
                $recordPastes = Paste::findOneImproved('pastes', ['slug' => $path]);
                $recordVersions = Paste::findVersionDetalied($path);
                if (!$recordPastes === false && !is_null($recordPastes->content)) {
                    Application::$app->isVersion = false;
                    $passwordController = new PasswordController();
                    return $passwordController->handlePassword($this->request, $recordPastes);
                    
                } else if (!is_null($recordVersions->content)) {
                    $this->response->setStatusCode(400);
                    throw new BadRequest();
                } else {
                    $this->response->setStatusCode(404);
                    throw new NotFoundException();
                }
            }
            else if (PathValidator::validateAddUserRequest($path)) {
                $path = substr($path, 1, -8);
                $recordPastes = Paste::findOneImproved('pastes', ['slug' => $path]);
                $recordVersions = Paste::findVersionDetalied($path);
                if (!$recordPastes === false && !is_null($recordPastes->content)) {
                    Application::$app->isVersion = false;
                    $update = new UpdateController();
                    return $update->handleUpdate($this->request, $recordPastes);
                } else if (!is_null($recordVersions->content)) {
                    $this->response->setStatusCode(400);
                    throw new BadRequest();
                } else {
                    $this->response->setStatusCode(404);
                    throw new NotFoundException();
                }
            } else if (PathValidator::validateDeleteRequest($path)) {
                $path = substr($path, 1, -7);
                $recordPastes = Paste::findOneImproved('pastes', ['slug' => $path]);
                $recordVersions = Paste::findVersionDetalied($path);
                if (!$recordPastes === false && !is_null($recordPastes->content)) {
                    Application::$app->isVersion = false;
                    $delete = new DeleteController();
                    return $delete->handleDelete($recordPastes);
                } else if (!is_null($recordVersions->content)) {
                    $delete = new DeleteController();
                    Application::$app->isVersion = true;
                    return $delete->handleDelete($recordVersions);
                } else {

                    $this->response->setStatusCode(404);
                    throw new NotFoundException();
                }
            } else if (PathValidator::validatePasteGetRequest($path)) {
                $path = substr($path, 1);
                $recordPastes = Paste::findOneImproved('pastes', ['slug' => $path]);
                $recordVersions = Paste::findVersionDetalied($path);

                // echo "<pre>";
                // var_dump($recordVersions);
                // var_dump($recordPastes);
                // echo "</pre>";

                if (!$recordPastes === false && !is_null($recordPastes->content)) {
                    Application::$app->isVersion = false;
                    $preview = new PreviewController();
                    return $preview->handlePreview($this->request, $recordPastes);
                } else if (!is_null($recordVersions->content)) {
                    $preview = new PreviewController();
                    Application::$app->isVersion = true;
                    return $preview->handlePreview($this->request, $recordVersions);
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
