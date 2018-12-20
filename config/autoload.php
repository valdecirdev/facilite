<?php
defined('BASEPATH') OR exit('No direct script access allowed');


$helper = ['url', 'auth'];


//============================================
// AUTOLOAD
//============================================

if ( isset($helper) && is_array($helper) ) {
    foreach ($helper as $key => $helper) {
        require_once ($config['helper_path'].$helper.$config['helper_sufix']);
    }
}