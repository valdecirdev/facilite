<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('base_url') )
{
    
    function base_url(string $uri = NULL)
    {
        global $config;
        return $config['base_url'].'/'.$uri;
    }

}