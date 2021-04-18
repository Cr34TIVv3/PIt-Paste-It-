<?php


namespace core;


class Controller
{
    public string $layout = 'general';

    public function render($view,$params = [])
    {
        if (strcmp ($view, "facing") == 0) 
        {
            $layout = 'facing';
            // include_once Application::$ROOT_DIR."/views/layouts/facing.php"; 
        }


        return Application::$app->router->renderView($view, $params);

        
    }
}