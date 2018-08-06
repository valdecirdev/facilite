<?php

    date_default_timezone_set('America/Sao_Paulo');
    define('DS', DIRECTORY_SEPARATOR);

    use database\Database;

    require_once (__DIR__.DS."..".DS."vendor".DS."autoload.php");
    require_once (__DIR__.DS."..".DS."app".DS."exceptions".DS."handler.php");

    new Database();
