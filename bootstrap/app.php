<?php

    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    define('DS', DIRECTORY_SEPARATOR);

    use database\Database;

    require_once (__DIR__.DS."..".DS."vendor".DS."autoload.php");
    // require_once (__DIR__.DS."..".DS."app".DS."exceptions".DS."handler.php");
    ini_set('display_errors', true);
    error_reporting(E_ALL);

    new Database();
