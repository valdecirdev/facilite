<?php

    use controller\{UsuarioController, ExperienciaController, AnuncioController, HabilidadeController, FormacaoController, LigacaoController};

    header('Access-Control-Allow-Origin: *');
    require_once('../../bootstrap/app.php');

    if (isset($_POST['acao'])) {
        switch ($_POST['acao']) {
            case 'logout':
                UsuarioController::logout();
                break;
            case 'login':
                echo UsuarioController::login($_POST);
                break;
            case 'register':
                echo UsuarioController::register($_POST);
                break;
            case 'delete_user':
                $usuario = new UsuarioController();
                $usuario->delete($_POST['id_usuario']);
                break;
            case 'up_slug':
                $usuario = new UsuarioController();
                echo $usuario->slug_update($_POST['slug'], $_POST['id']);
                break;
            case 'up_generico':
                $usuario = new UsuarioController();
                $usuario->gen_update($_POST['campo'], $_POST['valor'], $_POST['id']);
                break;
            case 'up_email':
                $usuario = new UsuarioController();
                echo $usuario->email_update($_POST['email'], $_POST['id']);
                break;
            case 'up_experiencia':
                $experiencia = new ExperienciaController();
                $experiencia->update($_POST);
                break;
            case 'del_experiencia':
                $experiencia = new ExperienciaController();
                $experiencia->delete($_POST['id_experiencia']);
                break;
            case 'add_habilidade':
                $habilidade = new HabilidadeController();
                echo $habilidade->insert($_POST['id_habilidade'], $_POST['id_usuario']);
                break;
            case 'del_habilidade':
                $habilidade = new HabilidadeController();
                $habilidade->delete($_POST['id_habilidade'], $_POST['id_usuario']);
                break;
            case 'up_servico':
                $anuncio = new AnuncioController();
                $anuncio->update($_POST);
                break;
            case 'add_servico':
                $anuncio = new AnuncioController();
                echo $anuncio->insert($_POST);
                break;
            case 'del_servico':
                $anuncio = new AnuncioController();
                $anuncio->delete($_POST['id_servico']);
                break;
            case 'ad_formacao':
                $formacao = new FormacaoController();
                echo $formacao->insert( $_POST['id_usuario'], $_POST['titulo'], $_POST['descr']);
                break;
            case 'up_formacao':
                $formacao = new FormacaoController();
                $formacao->update($_POST);
                break;
            case 'del_formacao':
                $formacao = new FormacaoController();
                $formacao->delete($_POST['id_formacao']);
                break;
            case 'ad_conexao':
                $ligacao = new LigacaoController();
                $ligacao->add_ligacao($_POST['id_usuario'], $_POST['id_contato']);
                break;
            case 'rem_conexao':
                $ligacao = new LigacaoController();
                $ligacao->rem_ligacao($_POST['id_usuario'], $_POST['id_contato']);
                break;
            case 'ad_experiencia':
                $experiencia = new ExperienciaController();
                echo $experiencia->insert($_POST['id_usuario'], $_POST['titulo'], $_POST['descr']);
                break;
            default:
                # code...
                break;
        }
    }
    if(isset($_FILES['usrFoto'])){
        session_start();
        $usuarioFuncs = new UsuarioController();
        $usuario = $usuarioFuncs->loadById($_SESSION['id']);
        echo $usuarioFuncs->update_image($usuario, $_FILES);
    }