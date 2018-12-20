<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('auth') )
{
    function auth()
    {
        if(isset($_SESSION['logged']) && isset($_SESSION['id']) && !is_null($_SESSION['id'])){
            return TRUE;
        }
        return FALSE;
    }
}

if(! function_exists('guest')){
    function guest()
    {
        if(!isset($_SESSION['id']) || is_null($_SESSION['id'])){
            return TRUE;
        }
        return FALSE;
    }
}

if(! function_exists('owner_session')){
    function owner_session(int $id)
    {
        if(auth()){
            if($_SESSION['id'] == $id){
                return TRUE;
            }
        }
        return FALSE;
    }
}