<?php
header('Access-Control-Allow-Origin: *');
require_once('../view/config.php'); 

if(isset($_POST['acao'])){
    if($_POST['acao'] == 'logout'){
        Usuario::logout();
    }else if($_POST['acao'] == 'login'){
        echo Usuario::login($_POST);
    }else if($_POST['acao'] == 'register'){
        Usuario::register($_POST);
    }else if($_POST['acao'] == 'up_slug'){
        $usuario = new Usuario();
        $slug = $_POST['slug'];
        $id = $_POST['id'];
        echo $usuario::slug_update($slug, $id);
    }else if($_POST['acao'] == 'up_generico'){
        $usuario = new Usuario();
        $campo = $_POST['campo'];
        $valor = $_POST['valor'];
        $id = $_POST['id'];
        $usuario::gen_update($campo, $valor, $id);
    }else if($_POST['acao'] == 'up_email'){
        $usuario = new Usuario();
        $email = $_POST['email'];
        $id = $_POST['id'];
        echo $usuario::email_update($email, $id);
    }else if($_POST['acao'] == 'up_experiencia'){
        $experiencia = new Experiencia();
        $experiencia::update($_POST);
    }else if($_POST['acao'] == 'del_experiencia'){
        $experiencia = new Experiencia();
        $experiencia::delete($_POST['id_experiencia']);
    }
    
    
    
    else if($_POST['acao'] == 'up_servico'){
        $anuncio = new Anuncio();
        echo $anuncio::update($_POST);
    }
    
    
    else if($_POST['acao'] == 'up_formacao'){
        $formacao = new Formacao();
        $formacao::update($_POST);
    }else if($_POST['acao'] == 'del_formacao'){
        $formacao = new Formacao();
        $formacao::delete($_POST['id_formacao']);
    }else if($_POST['acao'] == 'ad_conexao'){
        $ligacao = new Ligacao();
        $id_usuario = $_POST['id_usuario'];
        $id_contato = $_POST['id_contato'];
        $ligacao::add_ligacao($id_usuario, $id_contato);
    }else if($_POST['acao'] == 'rem_conexao'){
        $ligacao = new Ligacao();
        $id_usuario = $_POST['id_usuario'];
        $id_contato = $_POST['id_contato'];
        $ligacao::rem_ligacao($id_usuario, $id_contato);
    }else if($_POST['acao'] == 'ad_experiencia'){
        $experiencia = new Experiencia();
        $id_usuario = $_POST['id_usuario'];
        $titulo     = $_POST['titulo'];
        $descr      = $_POST['descr'];
        echo $experiencia::insert($id_usuario, $titulo, $descr);
    }else if($_POST['acao'] == 'ad_formacao'){
        $formacao = new Formacao();
        $id_usuario = $_POST['id_usuario'];
        $titulo     = $_POST['titulo'];
        $descr      = $_POST['descr'];
        echo $formacao::insert($id_usuario, $titulo, $descr);
    }
}
if(isset($_FILES['usrFoto'])){
    session_start();
    $usuarioFuncs = new Usuario();
    $usuario = $usuarioFuncs::loadById($_SESSION['id']);
    echo $usuarioFuncs::update_image($usuario, $_FILES);
}