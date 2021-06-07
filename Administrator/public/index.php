<?php

require_once __DIR__ . '/../vendor/autoloader.php';

use core\Application;
use controllers\AdminController;
use controllers\DeleteController;
use controllers\DeleteUserController;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$root_dirname = dirname(__DIR__);
$app = new Application($root_dirname);


$app->router->get('/', [AdminController::class, 'handleAdmin']);

$app->router->get('/[a-z0-9]{40}/delete', [DeleteController::class, 'handleDelete'], true);

// $app->router->get('/[a-z0-9]+@[a-z0-9]+(\.)[a-z]+/delete', [DeleteUserController::class, 'handleDelete'], true);
$app->router->get('/[0-9]+/delete', [DeleteUserController::class, 'handleDelete']);


$app->run();
