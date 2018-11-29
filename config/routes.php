<?php

$router
    
    ->get('/',  function () {
        $home = new Controller\HomeController();
        return $home->index(); 
    })
    ->get('/home',  function () { 
        $home = new Controller\HomeController();
        return $home->index();
    })
    ->get('/identifique-se',  function () {
        $login = new Controller\LoginController();
        return $login->index();
    })
    ->get('/cadastre-se',  function () {
        $register = new Controller\RegisterController();
        return $register->index();
    })
    ->get('/configuracoes',  function () { 
        $settings = new Controller\SettingsController();
        return $settings->index();
    })
    ->get('/search',  function () {
        $search = new Controller\BuscaController();
        return $search->index();
    })
    ->get('/messages', function () { 
        $messages = new Controller\MensagemController();
        return $messages->index();
    })
    ->get('/erro', function () { 
        $erro = new Controller\ErroController();
        return $erro->index();
    })
    ->get('/servico/([0-9]+)', function ($id) { 
        $service = new Controller\AnuncioController();
        return $service->index( $id );
    })
    ->get('/([@,a-z,0-9,.,A-Z,_-]+)', function ($slug) { 
        $profile = new Controller\ProfileController();
        return $profile->index( $slug );
    })



    ->post('/post/login', function () { return Controller\LoginController::login( $_POST ); })
    ->post('/post/logout', function () { return Controller\LoginController::logout(); })
    ->post('/post/register', function () { return Controller\RegisterController::register( $_POST ); })

    ->post('/post/update_avatar', function () { return Controller\ProfileController::updateAvatar( $_FILES ); })
    ->post('/post/up_apresentacao', function () { return Controller\ProfileController::updateApresentacao( $_POST['valor'], $_POST['id'] ); })

    ->post('/post/add_conexao', function () { return Controller\LigacaoController::add_ligacao( $_POST['id_usuario'], $_POST['id_contato'] ); })
    ->post('/post/rm_conexao', function () { return Controller\LigacaoController::rm_ligacao( $_POST['id_usuario'], $_POST['id_contato'] ); })

    ->post('/post/rm_experiencia', function () { return Controller\ExperienciaController::delete( $_POST['id_experiencia'] ); })
    ->post('/post/add_experiencia', function () { return Controller\ExperienciaController::insert( $_POST['id_usuario'], $_POST['titulo'], $_POST['descr'] ); })
    ->post('/post/up_experiencia', function () { return Controller\ExperienciaController::update( $_POST ); })
    
    ->post('/post/rm_formacao', function () { return Controller\FormacaoController::delete( $_POST['id_formacao'] ); })
    ->post('/post/up_formacao', function () { return Controller\FormacaoController::update( $_POST ); })
    ->post('/post/add_formacao', function () { return Controller\FormacaoController::insert( $_POST['id_usuario'], $_POST['titulo'], $_POST['descr'] ); })

    ->post('/post/rm_servico', function () { return Controller\AnuncioController::delete( $_POST['id_servico'] ); })
    ->post('/post/up_servico', function () { return Controller\AnuncioController::update( $_POST ); })
    ->post('/post/add_servico', function () { return Controller\AnuncioController::insert( $_POST ); })

    ->post('/post/rm_habilidade', function () { return Controller\HabilidadeController::delete( $_POST['id_habilidade'], $_POST['id_usuario'] ); })
    ->post('/post/add_habilidade', function () { return Controller\HabilidadeController::insert( $_POST['id_habilidade'], $_POST['id_usuario'] ); })

    ->post('/post/up_generico', function () { return Controller\SettingsController::genUpdate( $_POST['campo'], $_POST['valor'], $_POST['id'] ); })
    ->post('/post/up_email', function () { return Controller\SettingsController::emailUpdate( $_POST['email'], $_POST['id'] ); })
    ->post('/post/up_cep', function () { return Controller\SettingsController::cepUpdate( $_POST['cep'], $_POST['cidade'], $_POST['id'] ); })
    ->post('/post/rm_usuario', function () { return Controller\SettingsController::cepUpdate( $_POST['id_usuario'] ); })

    ->post('/post/new_message', function () { return Controller\MensagemController::newMessage( $_POST['mensagem'], $_POST['id_chat'], $_POST['remetente'] ); })
    ->post('/post/load_new_messages', function () { return Controller\MensagemController::loadNewMessages( $_POST['id_chat'], $_POST['remetente'], $_POST['destinatario'] ); })
    ->post('/post/hire_service', function () { return Controller\MensagemController::hire_service( $_POST['id_chat'] ); })
    
    ->post('/post/avaliar_servico', function () { return Controller\AvaliacaoController::avaliar($_POST); });


    // Rota para página de CONFIRMAÇÃO DE CONTA
    // ->get('/confirm', function () {
    //     session_start();
    //     if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
    //         $loggedUser = new UsuarioController();
    //         $loggedUser = $loggedUser->loadById($_SESSION['id']);
    //     }
    //     require __APP_ROOT__ . "/resources/view/confirma_email.php";
    // })

    // Rota para página de SERVIÇO
    