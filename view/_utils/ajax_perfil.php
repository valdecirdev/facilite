<?php
    
    header('Access-Control-Allow-Origin: *');
    require_once('../../autoload.php'); 

    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'logout':
                echo Usuario::logout();
                break;
            case 'login':
                echo Usuario::login($_POST);
                break;
            case 'register':
                echo Usuario::register($_POST);
                break;
            case 'delete_user':
                $usuario = new Usuario();
                echo $usuario->delete($_POST['id_usuario']);
                break;
            case 'up_slug':
                $usuario = new Usuario();
                echo $usuario->slug_update($_POST['slug'], $_POST['id']);
                break;
            case 'up_generico':
                $usuario = new Usuario();
                $usuario->gen_update($_POST['campo'], $_POST['valor'], $_POST['id']);
                break;
            case 'up_email':
                $usuario = new Usuario();
                echo $usuario->email_update($_POST['email'], $_POST['id']);
                break;
            case 'up_experiencia':
                $experiencia = new Experiencia();
                $experiencia->update($_POST);
                break;
            case 'del_experiencia':
                $experiencia = new Experiencia();
                $experiencia->delete($_POST['id_experiencia']);
                break;
            case 'add_habilidade':
                $habilidade = new Habilidade();
                echo $habilidade->insert($_POST['id_habilidade'], $_POST['id_usuario']);
                break;
            case 'del_habilidade':
                $habilidade = new Habilidade();
                $habilidade->delete($_POST['id_habilidade'], $_POST['id_usuario']);
                break;
            case 'up_servico':
                $anuncio = new Anuncio();
                echo $anuncio->update($_POST);
                break;
            case 'add_servico':
                $anuncio = new Anuncio();
                echo $anuncio->insert($_POST);
                break;
            case 'del_servico':
                $anuncio = new Anuncio();
                $anuncio->delete($_POST['id_servico']);
                break;
            case 'ad_formacao':
                $formacao = new Formacao();
                echo $formacao->insert( $_POST['id_usuario'], $_POST['titulo'], $_POST['descr']);
                break;
            case 'up_formacao':
                $formacao = new Formacao();
                $formacao->update($_POST);
                break;
            case 'del_formacao':
                $formacao = new Formacao();
                $formacao->delete($_POST['id_formacao']);
                break;
            case 'ad_conexao':
                $ligacao = new Ligacao();
                $ligacao->add_ligacao($_POST['id_usuario'], $_POST['id_contato']);
                break;
            case 'rem_conexao':
                $ligacao = new Ligacao();
                $ligacao->rem_ligacao($_POST['id_usuario'], $_POST['id_contato']);
                break;
            case 'ad_experiencia':
                $experiencia = new Experiencia();
                echo $experiencia->insert($_POST['id_usuario'], $_POST['titulo'], $_POST['descr']);
                break;
            default:
                # code...
                break;
        }
    }
    if(isset($_FILES['usrFoto'])){
        session_start();
        $usuarioFuncs = new Usuario();
        $usuario = $usuarioFuncs->loadById($_SESSION['id']);
        echo $usuarioFuncs->update_image($usuario, $_FILES);
    }