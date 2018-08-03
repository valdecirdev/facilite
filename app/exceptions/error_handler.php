<?php

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    use Monolog\Handler\FirePHPHandler;

    error_reporting(E_ALL & ~E_NOTICE); // altera se error, notice ou warning pode ser exibido

    function error_handler($code, $message, $file, $line){
        $logger = new Logger('System');
        $logger->pushHandler(new StreamHandler(__DIR__.DS.'..'.DS.'..'.DS.'storage'.DS.'logs'.DS.'system.txt', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());

        $context = array('Code'=>$code, 'File'=>$file, 'Line'=>$line);
        $logger->error($message, $context);

    }

    set_error_handler("error_handler");