<?php 


namespace controllers;

use core\Application;
use core\Controller;
use core\Request;

class SiteController extends Controller{

    public function home() {
        
        return Application::$app->router->renderView('signup');
    }

    public function signup() {
        return $this->render('signup');
    }

    public function handleContact(Request $request)
    {
        $body = $request->getBody();
        var_dump( $body );
    }
}