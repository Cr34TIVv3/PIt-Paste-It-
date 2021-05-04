<?php


namespace controllers;
use core\Controller;
use core\Request;
use core\Response;
use core\middlewares\AuthMiddleware;
use core\Application;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['handleAccount']));
    }
    public function handleAccount(Request $request, Response $respone)
    {
            return $this->render('account');
    }

    public function logout(Request $request, Response $respone) {
        Application::$app->logout();
        $respone->redirect('/home');
    }

}