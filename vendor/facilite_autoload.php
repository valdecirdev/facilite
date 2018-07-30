<?php

    spl_autoload_register(function($class_name) {

        $vendorDir  = dirname(dirname(__FILE__));
        $baseDir = dirname($vendorDir);

        if (file_exists($vendorDir.DS.$class_name.".class.php")) {
            require ($vendorDir.DS.$class_name.".class.php");
        } elseif (file_exists($baseDir.DS.$class_name.".class.php")) {
            require($baseDir . DS . $class_name . ".class.php");
        }

    });
