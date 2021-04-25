<?php 

namespace controllers;

use core\Application;
use core\Controller;
use core\Request;
use models\User;


class RegisterController extends Controller{
   

    public function handleRegistration(Request $request) {
        $user = new User();
        if( $request->getMethod() === "post")
        {
            
            $user->loadData($request->getBody()); 

            if($user->validate() && $user->save())
            {
                //display message 
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/home');
            }

            return $this->render('signup', ['model' => $user]);
        }
        else 
        {
            return $this->render('signup', ['model' => $user]);
        }
    }




}