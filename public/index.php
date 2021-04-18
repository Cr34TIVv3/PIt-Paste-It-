<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use controllers\AuthController;
use controllers\RegisterController;
use core\Application;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$root_dirname = dirname(__DIR__);
$app = new Application($root_dirname);

$app->router->get('/', 'facing');

$app->router->get('/home', 'home');

$app->router->get('/contact', 'contact'); 

$app->router->get('/signin','signin');



$app->router->get('/signin', [AuthController::class, 'handleLogin']); 
$app->router->post('/signin', [AuthController::class, 'handleLogin']);


$app->router->get('/signup', [RegisterController::class, 'handleRegistration']); 
$app->router->post('/signup', [RegisterController::class, 'handleRegistration']);


$app->router->get('/faq', 'faq'); 

$app->router->get('/account', 'account'); 




$app->run();





























