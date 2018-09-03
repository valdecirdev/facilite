<?php

define('__APP_ROOT__', dirname(__DIR__));
require __APP_ROOT__ . '/bootstrap/app.php';

use routes\Router;

$router = new Router();

$router
    ->get('/', function () {
        require __APP_ROOT__ . "/resources/view/index.php";
    })
    ->get('/home', function () {
        require __APP_ROOT__ . "/resources/view/index.php";
    })
    ->get('/configuracoes', function () {
        require __APP_ROOT__ . "/resources/view/configs.php";
    })
    ->get('/search', function () {
        require __APP_ROOT__ . "/resources/view/search.php";
    })
    ->get('/erro', function () {
        require __APP_ROOT__ . "/resources/view/error.php";
    })
    ->get('/identifique-se', function () {
        require __APP_ROOT__ . "/resources/view/login.php";
    })
    ->get('/cadastre-se', function () {
        require __APP_ROOT__ . "/resources/view/register.php";
    })
    ->get('/confirm', function () {
        require __APP_ROOT__ . "/resources/view/confirma_email.php";
    })
    ->get('/messages', function () {
        require __APP_ROOT__ . "/resources/view/messages.php";
    })
    ->get('/([@,a-z,0-9,A-Z,_-]+)', function () {
        require __APP_ROOT__ . "/resources/view/profile.php";
    });

echo $router($router->method(), $router->uri());