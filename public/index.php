<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use controllers\SiteController;
use core\Application;


$root_dirname = dirname(__DIR__);

$app = new Application($root_dirname);

$app->router->get('/', 'facing');

$app->router->get('/home', 'home');

$app->router->get('/contact', 'contact'); 

$app->router->get('/signin','signin');

$app->router->get('/signup', [SiteController::class, 'signup']); 
$app->router->post('/signup', [SiteController::class, 'handleRegistration']);

$app->router->get('/faq', 'faq'); 

$app->router->get('/account', 'faq'); 




$app->run();





























