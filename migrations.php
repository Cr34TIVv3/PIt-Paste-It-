<?php

require_once __DIR__ . '/vendor/autoloader.php';

use core\Application;

ini_set('display_errors', 1);
error_reporting(E_ALL);

$root_dirname =__DIR__;

 
$app = new Application($root_dirname);

$app->db->applyMigrations();



 




























