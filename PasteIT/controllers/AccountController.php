<?php


namespace controllers;

use core\Controller;
use core\Request;
use core\Response;
use core\middlewares\AuthMiddleware;
use core\Application;
use models\User;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware(['handleAccount']));
    }

    public function handleAccount(Request $request, Response $respone)
    {
        $user = new User();
        if ($request->getMethod() === "post") {
            $user->loadData($request->getBody());

            if ($user->validate() && $user->update()) {
                Application::$app->session->setFlash('success', 'Your credential has been updated');
                Application::$app->response->redirect('/account');
                exit;
            } else {
                Application::$app->session->setFlash('error', 'Invalid fields format');
            }

            return $this->render('account', ['model' => $user]);
        } else {
            return $this->render('account', ['model' => $user]);
        }
    }

    public function logout(Request $request, Response $respone)
    {
        Application::$app->logout();
        $respone->redirect('/home');
    }
}
