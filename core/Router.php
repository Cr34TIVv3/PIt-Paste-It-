<?php

namespace core;

class Router
{    
    public Request $request;
    public Response $response;
    protected array $routes = [];
    
    public function __construct(Request $request, Response $response) {
         $this->request = $request; 
         $this->response = $response;
    }
   
    public function get($path, $callback) {
        $this->routes['get'][$path] = $callback;
    }  
    
    public function post($path, $callback) {
        $this->routes['post'][$path] = $callback;
    }  
    
    public function resolve()
    {
        $path = $this->request->getPath();

        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }
        if(is_string($callback)) 
        { 
            return $this->renderView($callback);          
        }
        // if(is_array($callback)) {
        //     //  return $this->renderView
         
        // }
        return call_user_func($callback);  
    }

    public function renderView($view)
    {
        $layoutContent = $this->layoutContent($view);
        $viewContent = $this->renderOnlyView($view); 
        $viewStyle = $this->renderOnlyStyle($view);
        $viewJs = $this->renderOnlyScript($view);
        $layoutContent = str_replace('{{style}}', $viewStyle,  $layoutContent);
        $layoutContent = str_replace('{{script}}', $viewJs,  $layoutContent);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent($view) {
        ob_start();
        if (strcmp ($view, "facing") == 0) 
        {
            include_once Application::$ROOT_DIR."/views/layouts/facing.php"; 
        }
        else 
        {
            include_once Application::$ROOT_DIR."/views/layouts/general.php"; 
        }
        
        return ob_get_clean();
    }

    protected function renderOnlyView($view)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php"; 
        return ob_get_clean();
    }

    protected function renderOnlyStyle($view) {
        if ( strcmp("/", $view) == 0) {
            return "facing";
        }
        return $view;
    }

    protected function renderOnlyScript($view) {
        if(strcmp($view, "facing") == 0) {
            return "chart";
        }
        else if(strcmp($view, "account") == 0) {
            return "chart&nav";
        }
        else {
            return "nav";
        }
        
    }






    




































    
















    
}