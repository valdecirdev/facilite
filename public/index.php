<?php

define('DS', DIRECTORY_SEPARATOR);
define('BASEPATH', dirname(__DIR__).DS);

require (BASEPATH.'config'.DS.'bootstrap.php');

$router = new Core\Router();

require (BASEPATH.'app'.DS.'routes'.DS.'services.php');
require (BASEPATH.'app'.DS.'routes'.DS.'routes.php');

echo $router($router->method(), $router->uri());
