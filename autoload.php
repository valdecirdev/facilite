<?php

    define('DS', DIRECTORY_SEPARATOR);

    spl_autoload_register(function($class_name) {

        if (file_exists(".." . DS . "{$class_name}.class.php")) {
            require(".." . DS . "{$class_name}.class.php");
        } elseif (file_exists(".." . DS . ".." . DS . "{$class_name}.class.php")){
            require(".." . DS . ".." . DS . "{$class_name}.class.php");
        }

    });
