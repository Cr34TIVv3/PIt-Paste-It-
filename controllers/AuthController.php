<?php


namespace controllers;
use core\Application;
use core\Controller;
use core\Request;

class AuthController extends Controller {

    public function handleLogin(Request $request) 
    {

        if ( $request->getMethod() === "post" ) {
            $body = $request->getBody();
        }
        else 
        {
            return $this->render('signin');
        }
    }
}
