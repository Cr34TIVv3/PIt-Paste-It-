<?php

require_once __DIR__ . '/../../vendor/autoloader.php';

use controllers\APIgetPasteController;
use core\Application;

$root_dirname = dirname(__DIR__);
$app = new Application($root_dirname);


$app->router->post('/getPaste', [APIgetPasteController::class, 'handleGetter']);

$app->run();