<?php


namespace controllers;
use core\Controller;
use core\Request;
use core\Application;
use core\Response;
use models\Login;

class AuthController extends Controller {

    public function handleLogin(Request $request, Response $respone) 
    {

        $login = new Login();
        if( $request->getMethod() === "post")
        {
            
            $login->loadData($request->getBody()); 

            if($login->validate() && $login->login())
            {
                //display message 
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/home');
                exit;
            }

            return $this->render('signin', ['model' => $login]);
        }
        else 
        {
            return $this->render('signin', ['model' => $login]);
        }
    }
}
