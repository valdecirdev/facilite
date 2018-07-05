<?php

    define('DS',DIRECTORY_SEPARATOR);

    spl_autoload_register(function($class_name){

        $dirs = array(
            "..".DS."model".DS."DAO".DS.$class_name.".class.php",
            "..".DS."model".DS."objects".DS.$class_name.".class.php",
            "..".DS."model".DS.$class_name.".class.php",
            "..".DS."controller".DS.$class_name.".class.php",
            "..".DS."..".DS."model".DS."DAO".DS.$class_name.".class.php",
            "..".DS."..".DS."model".DS."objects".DS.$class_name.".class.php",
            "..".DS."..".DS."model".DS.$class_name.".class.php",
            "..".DS."..".DS."controller".DS.$class_name.".class.php"
        );
        foreach ($dirs as $key => $value) {
            if(file_exists($dirs[$key])){
                require($dirs[$key]);
                break;
            }
        }

    });
