<?php


require_once __DIR__ . '/vendor/autoloader.php';

use controllers\InsertPasteController;
use controllers\DeletePasteController;
use controllers\AddMembershipPasteController;
use core\Application;


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$root_dirname = dirname(__DIR__);
$app = new Application($root_dirname);


$app->router->post('/insertPaste', [InsertPasteController::class, 'handleInsert']);
$app->router->post('/deletePaste', [DeletePasteController::class, 'handleDelete']);
$app->router->post('/insertPaste', [AddMembershipPasteController::class, 'handleInsert']);



$app->run();