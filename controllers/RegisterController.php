<?php 

namespace controllers;

use core\Controller;
use core\Request;
use models\RegisterModel;


class RegisterController extends Controller{


    public function handleRegistration(Request $request) {
        $erros = [] ; 
        if( $request->getMethod() === "post")
        {
            $registerModel = new RegisterModel();
            $registerModel->loadData($request->getBody()); 


            if($registerModel->validate() && $registerModel->register())
            {
                return 'Succes'; 
            }
            $body = $request->getBody();
            // var_dump( $body );
        }
        else 
        {
            return $this->render('signup');
        }
    }




}