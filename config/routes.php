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

    
    ->post('/post/update_avatar', function () {
        $profile = new Controller\ProfileController();
        return $profile->updateAvatar( $_FILES ); 
    })
    ->post('/post/update_cover', function () {
        $profile = new Controller\ProfileController();
        return $profile->updateCover( $_FILES ); 
    })
    ->post('/post/up_apresentacao', function () {
        $profile = new Controller\ProfileController();
        return $profile->updateApresentacao( $_POST['valor'], $_POST['id'] ); 
    })


    // ROTAS DE CONEXAO DE USUARIOS
    ->post('/post/add_conexao', function () {
        $ligacao = new Controller\LigacaoController();
        return $ligacao->add_ligacao( $_POST['id_usuario'], $_POST['id_contato'] );
    })
    ->post('/post/rm_conexao', function () {
        $ligacao = new Controller\LigacaoController();
        return $ligacao->rm_ligacao( $_POST['id_usuario'], $_POST['id_contato'] );
    })

    // ROTAS DE EXPERIENCIA
    ->post('/post/rm_experiencia', function () {
        $experiencia = new Controller\ExperienciaController();
        return $experiencia->delete( $_POST['id_experiencia'] ); 
    })
    ->post('/post/add_experiencia', function () { 
        $experiencia = new Controller\ExperienciaController();
        return $experiencia->insert( $_POST['id_usuario'], $_POST['titulo'], $_POST['descr'] ); 
    })
    ->post('/post/up_experiencia', function () { 
        $experiencia = new Controller\ExperienciaController();
        return $experiencia->update( $_POST ); 
    })
    
    // ROTAS DE FORMAÇÃO
    ->post('/post/rm_formacao', function () {
        $formacao = new Controller\FormacaoController();
        return $formacao->delete( $_POST['id_formacao'] );
    })
    ->post('/post/up_formacao', function () {
        $formacao = new Controller\FormacaoController();
        return $formacao->update( $_POST );
    })
    ->post('/post/add_formacao', function () {
        $formacao = new Controller\FormacaoController();
        return $formacao->insert( $_POST['id_usuario'], $_POST['titulo'], $_POST['descr'] );
    })
    
    // ROTAS DE ANUNCIO
    ->post('/post/rm_servico', function () {
        $anuncio = new Controller\AnuncioController();
        return $anuncio->delete( $_POST['id_servico'] ); 
    })
    ->post('/post/up_servico', function () {
        $anuncio = new Controller\AnuncioController();
        return $anuncio->update( $_POST ); 
    })
    ->post('/post/add_servico', function () {
        $anuncio = new Controller\AnuncioController();
        return $anuncio->insert( $_POST ); 
    })
    
    // ROTAS DE HABILIDADE
    ->post('/post/rm_habilidade', function () { 
        $habilidade = new Controller\HabilidadeController();
        return $habilidade->delete( $_POST['id_habilidade'], $_POST['id_usuario'] ); 
    })
    ->post('/post/add_habilidade', function () { 
        $habilidade = new Controller\HabilidadeController();
        return $habilidade->insert( $_POST['id_habilidade'], $_POST['id_usuario'] ); 
    })

    
    // ROTAS DE Configurações
    ->post('/post/up_generico', function () { 
        $settings = new Controller\SettingsController();
        return $settings->genUpdate( $_POST['campo'], $_POST['valor'], $_POST['id'] ); 
    })
    ->post('/post/up_email', function () { 
        $settings = new Controller\SettingsController();
        return $settings->emailUpdate( $_POST['email'], $_POST['id'] ); 
    })
    ->post('/post/up_cep', function () { 
        $settings = new Controller\SettingsController();
        return $settings->cepUpdate( $_POST['cep'], $_POST['cidade'], $_POST['id'] ); 
    })
    ->post('/post/rm_usuario', function () { 
        $settings = new Controller\SettingsController();
        return $settings->delete( $_POST['id_usuario'] ); 
    })

    
    // ROTAS DE Mensagens
    ->post('/post/new_message', function () {
        $mensagem = new Controller\MensagemController();
        return $mensagem->newMessage( $_POST['mensagem'], $_POST['id_chat'], $_POST['remetente'] ); })
    ->post('/post/load_new_messages', function () {
        $mensagem = new Controller\MensagemController();
        return $mensagem->loadNewMessages( $_POST['id_chat'], $_POST['remetente'], $_POST['destinatario'] ); })
    ->post('/post/hire_service', function () {
        $mensagem = new Controller\MensagemController();
        return $mensagem->hire_service( $_POST['id_chat'] );
    })
    
    ->post('/post/avaliar_servico', function () {
        $avaliacao = new Controller\AvaliacaoController();
        return $avaliacao->avaliar($_POST); 
    });


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
    