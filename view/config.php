<?php
define('DS',DIRECTORY_SEPARATOR);
// define('BASE_DIR', dirname( __FILE__ ) . DS );

spl_autoload_register(function($class_name){
    $filenameDAO = "..".DS."model".DS."DAO".DS.$class_name.".class.php";
    $filenameModel = "..".DS."model".DS.$class_name.".class.php";
    $filenameControler = "..".DS."controller".DS.$class_name.".class.php";
    
    if(file_exists($filenameDAO)){
        require_once($filenameDAO);
    }else if(file_exists($filenameModel)){
        require_once($filenameModel);
    }else if(file_exists($filenameControler)){
        require_once($filenameControler);
    }else{
        throw new Exception("File path '{$class_name}' not found.");
    }
});

?>