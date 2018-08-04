<?php

define('__APP_ROOT__', dirname(__DIR__));
require __APP_ROOT__ . '/bootstrap/app.php';

use routes\Router;

$router = new Router();

$router
    ->get('/', function () {
        ob_start();
        require dirname(__DIR__) . "/resources/view/index.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    })
    ->get('/home', function () {
        ob_start();
        require dirname(__DIR__) . "/resources/view/index.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    })
    ->get('/configuracoes', function () {
        ob_start();
        require dirname(__DIR__) . "/resources/view/configs.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    })
    ->get('/search', function () {
        ob_start();
        require dirname(__DIR__) . "/resources/view/search.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    })
    ->get('/erro', function () {
        ob_start();
        require dirname(__DIR__) . "/resources/view/error.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    })
    ->get('/identifique-se', function () {
        ob_start();
        require dirname(__DIR__) . "/resources/view/login.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    })
    ->get('/cadastre-se', function () {
        ob_start();
        require dirname(__DIR__) . "/resources/view/register.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    })
    ->get('/confirm', function () {
        ob_start();
        require dirname(__DIR__) . "/resources/view/confirma_email.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    })
    ->get('/(\w+)', function () {
        ob_start();
        require dirname(__DIR__) . "/resources/view/profile.php";
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    });

echo $router($router->method(), $router->uri());