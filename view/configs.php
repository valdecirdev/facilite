<?php
    require('../autoload.php');
    // $uri = explode('/', $_SERVER["REQUEST_URI"]);
    // $slug = str_replace("@","",$uri[count($uri)-1]);

    // $anuncio = new Anuncio();
    // $ligacao = new Ligacao();
    // $user = new Usuario();
    // $usuario = $user->loadBySlug($slug) ?? header('location:erro');
    
    // $pg_title = $usuario->getNomeSimplesUsuario() . ' - ';
    // $description = $usuario->getApresentacaoUsuario();
    $pg_title = 'Configurações - ';
    include('_includes'.DS.'header.php');
    if(!isset($_SESSION['id'])){
        header('location: home');
    }

     
?>
    <input type="text" value="<?php if(isset($loggedUser)){echo $loggedUser->getIdUsuario();} ?>" id="id_usuario_logado" class="d-none">
    <section class="container-fluid" style="" id="profile-page">
        
        <div class="row">
            <div class="col-md-3" style="padding:20px;">
                <div class="row d-print-none">
                    <div class="col-md-12 " style="padding:0px;margin:0px;margin-bottom:-5px">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb" style="background-color:#fff;border-radius:0px">
                                <li class="breadcrumb-item"><a aria-label="inicio" href="home">Início</a></li>
                                <li class="breadcrumb-item active">Configurações</li>
                            </ol>
                        </nav>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12 profile-card text-center text-md-left">
                        <ul class="nav nav-tabs-confgs">
                            <li class="nav-item ">
                                <a aria-label="Visao geral" class="nav-link active" data-toggle="tab" href="#geral">Informações Básicas</a>
                            </li>
                            <li class="nav-item d-print-none">
                                <a aria-label="Serviços" class="nav-link" data-toggle="tab" href="#servicos">Informações Pessoais</a>
                            </li>
                            <li class="nav-item">
                                <a aria-label="Cadastro" class="nav-link" data-toggle="tab" href="#cadastro">Cadastro</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            





















            

            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12" id="visao-geral">
                        <div class="row">
                            <div class="col-md-12  profile-card">
                                <div class="tab-content" style="margin-top:-10px;">
                                    <div id="geral" class="tab-pane fade active show">
                                        <div class="col-12">
                                            <p class="pull-left" style="width:auto;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;">Informações básicas</p>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group" style="margin-top:70px">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend2">faciliteserv.com/</span>
                                                </div>
                                                <input type="text" class="form-control block-plaintext" name="des_slug" readonly disabled id="slugUsr" value="<?php if($loggedUser != NULL){echo $loggedUser->getSlugUsuario();} ?>">
                                            </div>
                                            <input type="text" class="form-control" name="des_nome" id="nomeUsr" value="<?php if($loggedUser != NULL){echo $loggedUser->getNomeUsuario();} ?>" placeholder="Nome Completo" style="margin-top:25px">
                                            <input type="email" class="form-control" name="des_email" id="emailUsr" value="<?php if($loggedUser != NULL){echo $loggedUser->getEmailUsuario();} ?>" placeholder="Email" style="margin-top:25px">
                                            <input type="text" class="form-control" name="des_ocupacao" id="ocupUsr" value="<?php if($loggedUser != NULL){echo $loggedUser->getOcupacaoUsuario();} ?>" placeholder="Ocupação" style="margin-top:25px">
                                        </div>
                                    </div>





                                    <div id="servicos" class="tab-pane fade">
                                        <div class="clearfix">
                                            <div class="col-12">
                                                <p class="pull-left" style="width:auto;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="far fa-address-card" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:10px"></i> Sobre</p>
                                                <div class="clearfix">
                                                        <button type="button" aria-label="Editar apresentação" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:13px;margin-bottom:-15px;" data-toggle="modal" data-target="#editApresentacaoModal"><i class="fa fa-edit" style="margin-right:5px;"></i>Editar</button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                   
        </div>
    </section>














<?php include('_includes'.DS.'footer.php'); ?>
<script src="view/_js/profile.js"></script>
<script>
    $('.open-Login').click(function(e){
        e.stopPropagation();
        $('#dropdownMenu2').dropdown('toggle');
    });
</script>
</html>