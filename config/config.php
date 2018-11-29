<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//============================================
// BASIC CONFIGS
//============================================

$config['base_url'] = 'http://dev.facilite.com';

$config['view_path'] = BASEPATH.'resources'.DS.'view';

$config['autoload'] = __DIR__.DS.'autoload.php';

$config['composer_autoload'] = BASEPATH.'vendor'.DS.'autoload.php';

$config['error_handler'] = BASEPATH.'app'.DS.'exceptions'.DS.'handler.php';

$config['helper_path'] = BASEPATH.'app'.DS.'helpers'.DS;

$config['helper_sufix'] = '_helper.php';

$config['development'] = TRUE; // Se verdadeiro exibe os erros do PHP na tela do navegador

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');