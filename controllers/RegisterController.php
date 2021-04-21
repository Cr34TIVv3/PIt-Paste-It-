<?php 

namespace controllers;

use core\Controller;
use core\Request;
use models\RegisterModel;


class RegisterController extends Controller{
   

    public function handleRegistration(Request $request) {
        $registerModel = new RegisterModel();
        $erros = [] ; 
        if( $request->getMethod() === "post")
        {
            
            $registerModel->loadData($request->getBody()); 

            if($registerModel->validate() && $registerModel->register())
            {
                return 'Succes'; 
            }

            return $this->render('signup', ['model' => $registerModel]);
        }
        else 
        {
            // echo "pas 1: ";
            return $this->render('signup', ['model' => $registerModel]);
        }
    }




}