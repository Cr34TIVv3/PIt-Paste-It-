<?php

namespace core;

use Exception;
use models\User;

class Application
{
    public static string $ROOT_DIR;
    public bool $isVersion;
    public string $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public ?Controller $controller = null;
    public Database $db;
    public Session $session;
    public ?DbModel $user;
    public function __construct($rootPath)
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
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user =  $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $this->response->setStatusCode($e->getCode());
            echo $this->router->renderView('_error', [
                'exception' => $e
            ]);
        }
    }

    public function login(DbModel $user)
    {

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

    public static function isGuest()
    {
        return !self::$app->user;
    }

    public static function isOwner($user_id)
    {
        if (self::isGuest()) {
            return false;
        } else if ($user_id != Application::$app->session->get('user')) {
            return false;
        }

        return true;
    }

    public static function isMember($id_paste)
    {

        if (self::isGuest()) {
            return false;
        }
        $user_id = Application::$app->session->get('user');

        $sql = 'SELECT COUNT(*) AS val FROM members m WHERE m.id_paste =' . $id_paste . ' AND   m.id_user=' . $user_id . ';';

        $statement = Application::$app->db->pdo->prepare($sql);

        $statement->execute();
        $result = $statement->fetchObject();


        if (strcmp($result->val, '1') == 0) {

            return true;
        } else {
            return false;
        }
    }
}
