<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', dirname(__DIR__).DS);

require (BASEPATH.'bootstrap'.DS.'app.php');

$router = new Core\Router();

require (BASEPATH.'config'.DS.'routes.php');

echo $router($router->method(), $router->uri());
