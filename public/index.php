<?php

define('__APP_ROOT__', dirname(__DIR__));
require __APP_ROOT__ . '/bootstrap/app.php';

use controller\{UsuarioController, AnuncioController};
use routes\Router;

$router = new Router();

$router
    // Rota para página INICIAL
    ->get('/', function () {
        session_start();
        if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
            $loggedUser = new UsuarioController();
            $loggedUser = $loggedUser->loadById($_SESSION['id']);
        }
        $pg_title = '';
        require __APP_ROOT__ . "/resources/view/index.php";
    })
    // Rota para página INICIAL
    ->get('/home', function () {
        session_start();
        if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
            $loggedUser = new UsuarioController();
            $loggedUser = $loggedUser->loadById($_SESSION['id']);
        }
        $pg_title = '';
        require __APP_ROOT__ . "/resources/view/index.php";
    })
    // Rota para página de CONFIGURACOES
    ->get('/configuracoes', function () {
        session_start();
        if(!isset($_SESSION['id'])){
            header('location: home');
        }
        $loggedUser = new UsuarioController();
        $loggedUser = $loggedUser->loadById($_SESSION['id']);
        $pg_title = 'Configurações - ';
        require __APP_ROOT__ . "/resources/view/configs.php";
    })
    // Rota para página de PESQUISA
    ->get('/search', function () {
        session_start();
        if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
            $loggedUser = new UsuarioController();
            $loggedUser = $loggedUser->loadById($_SESSION['id']);
        }
        require __APP_ROOT__ . "/resources/view/search.php";
    })
    // Rota para página de ERRO
    ->get('/erro', function () {
        session_start();
        if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
            $loggedUser = new UsuarioController();
            $loggedUser = $loggedUser->loadById($_SESSION['id']);
        }
        $pg_title = 'Pagina Não Encontrada - ';
        require __APP_ROOT__ . "/resources/view/error.php";
    })
    // Rota para página de LOGIN
    ->get('/identifique-se', function () {
        session_start();
        $pg_title = "Identifique-se - ";
        require __APP_ROOT__ . "/resources/view/login.php";
    })
    // Rota para página de CADASTRO
    ->get('/cadastre-se', function () {
        session_start();
        $pg_title = "Cadastre-se - ";
        require __APP_ROOT__ . "/resources/view/register.php";
    })
    // Rota para página de CONFIRMAÇÃO DE CONTA
    ->get('/confirm', function () {
        session_start();
        if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
            $loggedUser = new UsuarioController();
            $loggedUser = $loggedUser->loadById($_SESSION['id']);
        }
        require __APP_ROOT__ . "/resources/view/confirma_email.php";
    })
    // Rota para página de MENSAGENS
    ->get('/messages', function () {
        session_start();
        $pg_title = 'Mensagem - '; 
        if(!isset($_SESSION['id']) || is_null($_SESSION['id'])){
            header('location:home');
        }
        $loggedUser = new UsuarioController();
        $loggedUser = $loggedUser->loadById($_SESSION['id']);
        require __APP_ROOT__ . "/resources/view/messages.php";
    })

    // Rota para página de SERVIÇO
    ->get('/servico/([0-9]+)', function ($id) {
        session_start();

        $anuncio = new AnuncioController();
        $servico = $anuncio->loadByID($id) ?? header('location:erro');
        $user    = new UsuarioController();

        $usuario     = $user->loadById($servico->id_usuario) ?? header('location:erro');
        $pg_title    = $servico->categoria->des_descricao.' - ';
        $description = $servico->des_descricao;

        $donoServico = false;
        if (isset($_SESSION['id'])&&($_SESSION['id'] == $usuario->id_usuario)) {
            $donoServico = true;
            $loggedUser  = $usuario;
        } else {
            if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
                $loggedUser = new UsuarioController();
                $loggedUser = $loggedUser->loadById($_SESSION['id'], ['id_usuario', 'des_slug', 'des_foto', 'des_nome_exibicao', 'des_status']);
            }
        }
        
        require __APP_ROOT__ . "/resources/view/service.php";
    })

    // Rota para página de PERFIL
    ->get('/([@,a-z,0-9,.,A-Z,_-]+)', function ($slug) {
        session_start();

        $user    = new UsuarioController();
        $usuario = $user->loadBySlug($slug) ?? header('location:erro');
        $pg_title = $usuario->des_nome_exibicao.' - ';
        $description = $usuario->des_apresentacao;

        $donoPerfil = false;
        if (isset($_SESSION['id'])&&($_SESSION['id'] == $usuario->id_usuario)) {
            $donoPerfil = true;
            $loggedUser = $usuario;
        } else {
            if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
                $loggedUser = new UsuarioController();
                $loggedUser = $loggedUser->loadById($_SESSION['id'], ['id_usuario', 'des_slug', 'des_foto', 'des_nome_exibicao', 'des_status']);
            }
        }
        
        require __APP_ROOT__ . "/resources/view/profile.php";
    });

echo $router($router->method(), $router->uri());
