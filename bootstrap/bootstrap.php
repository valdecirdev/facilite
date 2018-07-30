<?php

    date_default_timezone_set('America/Sao_Paulo');
    define('DS', DIRECTORY_SEPARATOR);

    if (file_exists(".." . DS . "vendor" . DS . "autoload.php")) {
        require(".." . DS . "vendor" . DS . "error_handler.php");
        require(".." . DS . "vendor" . DS . "autoload.php");
        require(".." . DS . "vendor" . DS . "facilite_autoload.php");
    } else if(file_exists(".." . DS . ".." . DS . "vendor" . DS . "autoload.php")) {
        require(".." . DS . ".." . DS . "vendor" . DS . "error_handler.php");
        require(".." . DS . ".." . DS . "vendor" . DS . "autoload.php");
        require(".." . DS . "vendor" . DS . "facilite_autoload.php");
    }