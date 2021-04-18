<?php 

namespace controllers;

use core\Controller;
use core\Request;

class RegisterController extends Controller{


    public function handleRegistration(Request $request) {
        if( $request->getMethod() === "post")
        {
            $body = $request->getBody();
            var_dump( $body );
        }
        else 
        {
             return $this->render('signup');
        }
        
    }




}