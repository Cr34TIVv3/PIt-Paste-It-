<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use controllers\AccountController;
use controllers\AuthController;
use controllers\RegisterController;
use controllers\FacingController;
use controllers\FaqController;
use controllers\ContactController;
use controllers\HomeController;
use controllers\PreviewController;
use core\Application;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$root_dirname = dirname(__DIR__);
$app = new Application($root_dirname);

///           require only get method

$app->router->get('/', [FacingController::class, 'handleFacing']);
$app->router->get('/contact', [ContactController::class, 'handleContact']); 
$app->router->get('/faq', [FaqController::class, 'handleFaq']); 
$app->router->get('/logout', [AccountController::class, 'logout']); 

///          require get and post

$app->router->get('/signin', [AuthController::class, 'handleLogin']); 
$app->router->post('/signin', [AuthController::class, 'handleLogin']);

$app->router->get('/signup', [RegisterController::class, 'handleRegistration']); 
$app->router->post('/signup', [RegisterController::class, 'handleRegistration']);

$app->router->get('/account', [AccountController::class,'handleAccount']); 
$app->router->post('/account', [AccountController::class,'handleAccount']); 

$app->router->get('/home', [HomeController::class, 'handleHome']);
$app->router->post('/home', [HomeController::class, 'handleHome']);


$app->router->get('/home/{slug}', [HomeController::class, 'handlePasteRequest']);


$app->run();





























