<?php


namespace core;


class Controller
{
    public string $layout = 'general';

    public function render($view,$params = [])
    {
       
        if (strcmp ($view, "facing") == 0) 
        {
            $this->layout = 'facing';
        }

        return Application::$app->router->renderView($view, $params);

    }
}