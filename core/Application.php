<?php

namespace core;


class Application
{ 
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Controller $controller;
    public Database $db;
    public function __construct($rootPath)
    { 
        self::$ROOT_DIR = $rootPath; 
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response(); 
        $this->router = new Router($this->request, $this->response);

        $dns = "mysql:host=localhost;dbname=pasteit";
        $name = "rafa";
        $password = "rafa";
        $this->db = new Database($dns, $name, $password);
    }

    public function run() {
        echo $this->router->resolve();        
    }
}