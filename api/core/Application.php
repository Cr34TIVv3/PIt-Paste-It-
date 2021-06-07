<?php

namespace core;

use Exception;

class Application
{
    public static string $ROOT_DIR;

    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public ?Controller $controller = null;
    public Database $db;
    public function __construct($rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);

        $dns = "mysql:host=localhost;dbname=pasteit";
        $name = "cosmin";
        $password = "cosmin";
        $this->db = new Database($dns, $name, $password);
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo json_encode(array("message" => "Unable to resolve request."));
           
        }
    }
}
