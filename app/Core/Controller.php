<?php

namespace Core;

class Controller
{
    public static function view(string $view_name, string $pg_title = '')
    {
        global $config;
            
        ob_start('ob_gzhandler');
        require($config['view_path'].$view_name.'.php');
        ob_end_flush();
    }
}
