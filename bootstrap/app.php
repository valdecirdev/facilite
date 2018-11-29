<?php

    // CONFIG LOAD
    require_once (BASEPATH."config".DS."config.php");
    
    // SELF AUTOLOAD
    require_once ($config['autoload']);
    require_once ($config['composer_autoload']);
    require_once ($config['error_handler']);
    
    if ($config['development']) {
        ini_set('display_errors', TRUE);
        error_reporting(E_ALL);
    }    

    use Database\Database;
    new Database();
    