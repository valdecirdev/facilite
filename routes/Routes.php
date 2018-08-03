<?php

use routes\Router;

$router = new Router();

$router->set('', 'index.php');

$router->set('/', 'index.php');

$router->set('home', 'index.php');

$router->set('configuracoes', 'configs.php');

$router->set('search', 'search.php');

$router->set('erro', 'error.php');

$router->set('identifique-se', 'login.php');

$router->set('cadastre-se', 'login.php');

$router->set('confirm', 'confirma_email.php');