<?php

namespace core;

use models\User;

class Application
{ 
    public static string $ROOT_DIR;
  
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public Controller $controller;
    public Database $db;
    public Session $session;
    public ?DbModel $user;
    public function __construct($rootPath)
    //dbmodel
    { 
        $this->userClass = User::class;
        self::$ROOT_DIR = $rootPath; 
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response(); 
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);

        $dns = "mysql:host=localhost;dbname=pasteit";
        $name = "cosmin";
        $password = "cosmin";
        $this->db = new Database($dns, $name, $password);

        $primaryValue = $this->session->get('user');    
        if($primaryValue)
        {
             $primaryKey = $this->userClass::primaryKey();
             $this->user =  $this->userClass::findOne([$primaryKey => $primaryValue]);
        } 
        else 
        {
            $this->user = null;
        }
      
    }

    public function run() {
        echo $this->router->resolve();        
    }

    public function login(DbModel $user)
    {
        echo "sunt in login";
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryValue = $user->{$primaryKey};
        $this->session->set('user', $primaryValue);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public static function isGuest() {
        var_dump(self::$app->user);
        return !self::$app->user;
    }
}
















































