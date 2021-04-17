<?php 


namespace controllers;

use core\Application;

class SiteController {

    public function home() {
        
        return Application::$app->router->renderView('signup');
    }

    public function signup() {
        return Application::$app->router->renderView('signup');
    }

    public function handleRegistration() {
        return 'Handling';
    }
}