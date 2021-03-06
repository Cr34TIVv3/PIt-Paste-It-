<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use controllers\AccountController;
use controllers\AuthController;
use controllers\RegisterController;
use controllers\FacingController;
use controllers\FaqController;
use controllers\ContactController;
use controllers\DeleteController;
use controllers\HomeController;
use controllers\PasswordController;
use controllers\PreviewController;
use controllers\UpdateController;
use core\Application;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$root_dirname = dirname(__DIR__);
$app = new Application($root_dirname);

///           require only post method

$app->router->post('/update', [UpdateController::class, 'handleUpdate']);

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

$app->router->get('/account', [AccountController::class, 'handleAccount']);
$app->router->post('/account', [AccountController::class, 'handleAccount']);

$app->router->get('/home', [HomeController::class, 'handleHome']);
$app->router->post('/home', [HomeController::class, 'handleHome']);

//smart routes

$app->router->get('/[a-z0-9]{40}', [PreviewController::class, 'handlePreview'], true);
$app->router->post('/[a-z0-9]{40}', [PreviewController::class, 'handlePreview'], true);

$app->router->get('/[a-z0-9]{40}/delete', [DeleteController::class, 'handleDelete'], true);

$app->router->get('/[a-z0-9]{40}/password', [PasswordController::class, 'handlePassword'], true);

$app->router->get('/[a-z0-9]{40}/addUser', [UpdateController::class, 'handleUpdate'], true);





$app->run();
