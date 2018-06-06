<?php
    require_once('config.php');
    $url = $_SERVER["REQUEST_URI"];
    $uri = explode('/', $url);
    $slug = str_replace("@","",$uri[count($uri)-1]);

    $infoUsuario = new Usuario();
    $usuario = $infoUsuario->loadBySlug($slug);
    if(is_null($usuario)){
        header('location:404');
    }
    
    $includes = true;
    $pg_title = $usuario->getNomeSimplesUsuario() . ' - ';
    include_once('_includes'.DS.'header.php');

    $donoPerfil = false;
    if(isset($_SESSION['id'])&&($_SESSION['id'] == $usuario->getidUsuario())){
        $donoPerfil = true;
    }
?>
    <input type="text" value="<?php if(isset($loggedUser)){echo $loggedUser->getIdUsuario();} ?>" id="id_usuario_logado" class="d-none">
    <section class="container-fluid" style="" id="profile-page">
        <div class="row d-print-none">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home">Início</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php if($usuario != NULL){echo $usuario->getNomeSimplesUsuario();} ?></li>
                </ol>
            </nav>
        </div>
        <div class="row" style="margin-top:-30px;">
            <div class="col-md-3" style="padding:20px;padding-right:25px">
                <div class="row">
                    <div class="col-md-12 profile-card text-center text-md-left">
                        <div class="img-profile">
                        <?php if($donoPerfil){ ?>
                            <form method="post" id="form-usrFoto" enctype="multipart/form-data" style="position:absolute">
                                <input type="file" id="usrFoto" name="usrFoto" accept="image/jpeg" style="max-width:100%;display:none">
                            </form><?php } ?>
                            <img src="view/_img/profile/<?php echo $usuario->getFotoUsuario(); ?>" alt="" id="usrFotoView">
                            <?php if($donoPerfil){ ?>
                                <div id="fotoMouseOn" style="display:none">
                                    <img src="view/_img/camera.png" alt="">
                                </div>
                            <?php } ?>
                        </div>
                        <div class="infos">
                            <h5 class="profile-name text-center"><?php if($usuario != NULL){echo $usuario->getNomeSimplesUsuario();} ?></h5>

                            <div class="text-center">
                                <?php if($usuario->getOcupacaoUsuario() != NULL){ ?>
                                    <p style="margin-top:-5px;font-size:14px;"><span id="sideOcupacao"><?php echo $usuario->getOcupacaoUsuario(); ?></span></p>
                                <?php }
                                 if((isset($_SESSION['id']))&&($_SESSION['id'] != $usuario->getidUsuario())){ ?>
                                    <button class="btn btn-fc-primary btn-radius btn-rounded d-print-none" style="margin-bottom:10px;">Entrar em Contato</button>
                                <?php }else if(!isset($_SESSION['id'])){ ?>
                                    <button class="btn btn-fc-primary btn-radius d-print-none open-Login" style="margin-bottom:10px;">Entrar em Contato</button>
                                <?php } ?>
                            </div>

                            <div class="list-infos">
                                <p class="sub"><i class="fa fa-at"></i> <span><?php if($usuario != NULL){echo $usuario->getSlugUsuario();} ?></span></p>
                                <?php if(($usuario->getSexoUsuario() != NULL)&&($usuario->getIdadeUsuario() != NULL)){ ?>
                                    <p class="sub"><i class="fa fa-users"></i><span id="sideSexo"><?php echo $usuario->getSexoUsuario() .', '; ?></span><span id="sideIdade"><?php echo $usuario->getIdadeUsuario().' anos'; ?></span></p>
                                <?php }else if($usuario->getIdadeUsuario() != NULL){ ?>
                                    <p class="sub"><i class="fa fa-users"></i><span id="sideIdade"><?php echo $usuario->getIdadeUsuario().' anos'; ?></span></p>
                                <?php } if($usuario->getCidadeUsuario() != NULL){ ?>
                                    <p class="sub"><i class="fa fa-map-marker" style="margin-left: 3px;margin-right: 8px;"></i><?php echo $usuario->getCidadeUsuario(); ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="col-md-6">
                <div class="row" style="margin-top:0px">
                    <div class="col-md-12" style="padding:20px;">
                        <div class="row">
                            <div class="col-md-12  profile-card">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item ">
                                        <a class="nav-link active" data-toggle="tab" href="#geral">Visão Geral</a>
                                    </li>
                                    <?php $anuncios = new Anuncio(); if((count($anuncios->loadByUser($usuario->getidUsuario()))>0)||((isset($_SESSION['id']))&&($_SESSION['id']==$usuario->getIdUsuario()))){ ?>
                                        <li class="nav-item d-print-none">
                                            <a class="nav-link" data-toggle="tab" href="#servicos">Serviços</a>
                                        </li>
                                    <?php } 
                                    if($donoPerfil){ ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#cadastro">Cadastro</a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <div class="tab-content" style="padding-top:20px;">
                                    <div id="geral" class="tab-pane fade active show">
                                    <!-- SECAO DE APRESENTACAO -->
                                    

                                        <p style="margin-left:12px;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="far fa-address-card" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:7px"></i> Sobre</p>
                                        <div id="apresentacao" style="margin-left:33px;">                                  
                                            <div class="col-12" style="margin-top:15px;margin-bottom:15px">
                                                <div class="clearfix">
                                                    <input type="text" style="position:absolute; display:none" id="id_usuario" value="<?php echo $usuario->getIdUsuario(); ?>">
                                                    <p class="form-control-plaintext" id="des_apresentacao" style="margin-top:-10px;height:auto;resize: none;margin-left:-7px;margin-right:-10px;font-weight:300"><?php echo $usuario->getApresentacaoUsuario(); ?>
                                                    <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getidUsuario()){ ?>
                                                        <span class="clearfix pull-right" style="padding:0px;margin:0px;font-weight:normal">
                                                            <a class="btn-editApres" style="color:blue;cursor:pointer;margin-right:10px">Editar</a>
                                                        </span>
                                                    <?php }} ?></p>
                                                </div>
                                            </div>
                                        </div>



                                        
                                        


                                        <div class="clearfix" style="margin-bottom:20px;">
                                            <p class="pull-left" style="width:auto;margin-left:12px;margin-top: 30px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-suitcase" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:10px"></i> Experiências</p>
                                            <?php if($donoPerfil){ ?>
                                                <div class="col-12">
                                                    <div class="clearfix">
                                                        <button type="button" class="btn btn-primary pull-right btn-sm d-print-none" style="margin-top:25px;margin-bottom:-15px;" data-toggle="modal" data-target="#addExperienciaModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                    </div>
                                                </div>
                                            <?php } ?> 
                                        </div>
                                        <div id="experiencias-itens" style="margin-left:33px;">                                  
                                        <?php $experiencias = new Experiencia();
                                            $experiencias = $experiencias->loadByUser($usuario->getIdUsuario());
                                            if(count($experiencias)>0){
                                            foreach ($experiencias as $key => $value) { ?>
                                                <div class="col-12" style="margin-top:15px;margin-bottom:5px">
                                                    <div class="clearfix">
                                                        <input type="text" class="id_experiencia" value="<?php echo $experiencias[$key]->getIdExperiencia(); ?>" style="display:none">
                                                        <p class="des_titulo_experiencia" style="width:auto; margin-left:-5px;font-weight:400; padding-right:25px;font-size:17px;margin-bottom:0px"><?php echo $experiencias[$key]->getTituloExperiencia(); ?></p>
                                                        <p class="col-12 desc des_descricao_experiencia" style="margin-left:-10px;margin-right:-10px; padding-left:5px;padding-bottom:1px;padding-top:1px;font-weight:300;font-size:16px;"><?php echo $experiencias[$key]->getDescricaoExperiencia(); ?></p>
                                                        <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getidUsuario()){ ?>
                                                            <span class="clearfix pull-right" style="margin-top:-20px;padding:0px;margin:0px;font-weight:normal">
                                                                <a class="btn-editExperiencia" style="color:blue;cursor:pointer;margin-right:10px">Editar</a>
                                                                <a class="btn-delExperiencia text-danger" style="cursor:pointer">Deletar</a>
                                                            </span>
                                                        <?php }} ?>
                                                    </div>
                                                </div>
                                        <?php }} ?>
                                        </div>


                                        <div class="clearfix">
                                            <p class="pull-left" style="width:auto;margin-left:12px;margin-top: 30px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-trophy" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:10px"></i> Formação</p>
                                            <?php if($donoPerfil){ ?>
                                                <div class="col-12">
                                                    <div class="clearfix">
                                                        <button type="button" class="btn btn-primary pull-right btn-sm d-print-none" style="margin-top:25px;margin-bottom:-15px;" data-toggle="modal" data-target="#addFormacaoModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                    </div>
                                                </div>
                                            <?php } ?> 
                                        </div>
                                        <div id="formacoes-itens" class="row" style="margin-top:10px;margin-left:36px;padding-right:50px;">
                                            <?php $formacoes = new Formacao();
                                            $formacoes = $formacoes->loadByUser($usuario->getIdUsuario());
                                            foreach ($formacoes as $key => $value) { ?>
                                                <div class="col-12">
                                                    <div class="clearfix">
                                                        <input type="text" class="id_formacao" value="<?php echo $formacoes[$key]->getIDFormacao(); ?>" style="display:none">
                                                        <!-- <input type="text" class="form-control-plaintext des_titulo_formacao pull-left col-8" readonly disabled value="<?php echo $formacoes[$key]->getTituloFormacao(); ?>" style="height:auto;resize: none;margin-left:-10px;font-weight:400; padding-left:5px;margin-right:-10px;font-size:17px"> -->
                                                        <p class="form-control-plaintext des_titulo_formacao pull-left col-12" style="height:auto;resize: none;margin-left:-10px;font-weight:400; padding-left:5px;margin-right:-10px;font-size:17px"><?php echo $formacoes[$key]->getTituloFormacao(); ?></p>
                                                        
                                                        <!-- <textarea class="desc des_descricao_formacao form-control-plaintext" readonly disabled name="des_apresentacao" id="des_apresentacao" rows="1" cols="30" style="height:auto;resize: none;margin-left:-10px;margin-right:-10px; padding-left:5px; padding-top:0px;font-weight:300" spellcheck="false"><?php echo $formacoes[$key]->getDescricaoFormacao(); ?></textarea> -->
                                                        <p class="desc des_descricao_formacao" id="des_apresentacao" style="margin-left:-10px;margin-right:-10px; padding-left:5px; padding-top:0px;font-weight:300"><?php echo $formacoes[$key]->getDescricaoFormacao(); ?>
                                                        <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getidUsuario()){ ?>
                                                            <span class="clearfix pull-right" style="padding:0px;margin:0px;font-weight:normal">
                                                                <a class="btn-editFormacao" style="color:blue;cursor:pointer;margin-right:10px">Editar</a>
                                                                <a class="btn-delFormacao text-danger" style="cursor:pointer">Deletar</a>
                                                            </span>
                                                        <?php }} ?></p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>


                                        <div class="clearfix">
                                            <p class="pull-left" style="width:auto;margin-left:17px;margin-top: 30px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-lightbulb" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:10px"></i> Habilidades</p>
                                            <?php if($donoPerfil){ ?>
                                                <div class="col-12">
                                                    <div class="clearfix">
                                                        <button type="button" class="btn btn-primary pull-right btn-sm d-print-none" style="margin-top:25px;margin-bottom:-15px;" data-toggle="modal" data-target="#addHabilidadeModal"><i class="fa fa-edit" style="margin-right:5px;"></i>Editar</button>
                                                    </div>
                                                </div>
                                            <?php } ?> 
                                        </div>
                                        <div id="habilidades-itens" style="margin-top:0px">
                                            <div class="row" style="margin-left:30px;">
                                                <?php $habilidades = new Habilidade();
                                                $habilidades = $habilidades->loadByUser($usuario->getIdUsuario());
                                                foreach ($habilidades as $key => $value) { ?>
                                                <div class="col-md-4">
                                                    <div class="clearfix">
                                                        <input type="text" class="id_habilidade" value="<?php echo $habilidades[$key]->getIdHabilidade(); ?>" style="display:none">
                                                        <p class="habilidade-label form-control-plaintext des_descricao_habilidade pull-left"><?php echo $habilidades[$key]->getDescricaoHabilidade(); ?></p>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="servicos" class="tab-pane fade">
                                    <?php if($donoPerfil){ ?>
                                        <div class="col-12">
                                            <div class="clearfix">
                                                <button type="button" class="btn btn-primary pull-right btn-sm d-print-none" style="margin-top:10px;margin-bottom:-15px;" data-toggle="modal" data-target="#addServicoModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                            </div>
                                        </div>
                                    <?php } ?>
                                        <div class="row" style="margin-left:5px; margin-top:30px">
                                            <?php $categorias = new Categoria();
                                            $modalidades = new Modalidade();
                                            //   $servicos = new Servicos();
                                            $anuncios = new Anuncio();
                                            $anuncio = $anuncios->loadByUser($usuario->getidUsuario()); 
                                            foreach ($anuncio as $key => $value) { 
                                                $categoria = $categorias->loadById($anuncio[$key]->getIdCategoriaAnuncio());
                                                $modalidade = $modalidades->loadById($anuncio[$key]->getIdModalidadeAnuncio());
                                            ?>
                                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                <div class="card profile-card card-body">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <a href="#">
                                                                <div class="">
                                                                    <i class="<?php echo $categoria->getIconeCategoria(); ?> fa-2x icon-align-center" aria-hidden="true"></i>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-10 title-card">
                                                            <a href="">
                                                                <h4 class="job-title font-weight-bold">
                                                                    <?php echo $categoria->getDescricaoCategoria(); ?>
                                                                </h4>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 numbers-card">
                                                            <div class="row text-center" style="padding-top:10px;">
                                                                <div style="width: 30%">
                                                                    <span style="font-size: 22px;font-weight:bold;">25</span>
                                                                        <p style="margin-top: -5px">Concluídos</p>
                                                                    </div>
                                                            <div style="width: 40%">
                                                                <span style="font-size: 13px">R$</span>
                                                                <span style="font-size:22px;font-weight:bold;"><?php echo $anuncio[$key]->getPrecoAnuncio(); ?></span>
                                                                <p style="margin-top: -5px"><?php echo $modalidade->getDescricaoModalidade(); ?></p>
                                                            </div>
                                                            <div style="width: 30%">
                                                                <span style="font-size:22px;font-weight:bold;">20</span>
                                                                <p style="margin-top: -5px">Avaliações</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 desc-card">
                                                        <p><?php echo $anuncio[$key]->getDescricaoAnuncio(); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php if($donoPerfil){ ?>
                                <div id="cadastro" class="tab-pane fade" style="margin-top: 20px;">
                                    <div class="col-12" style="min-height:25px; margin-top:20px" >
                                        <div class="pull-left">
                                            <h6 class="skills-title">Suas Informações</h6>
                                        </div>
                                    </div>
                                    <div class="col-12" style="margin-left:0px; max-width:96%;margin-top:15px;">
                                            <div class="form-group">
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label for="slugUsr" style="margin-top: 5px;">Nome de Usuário</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="inputGroupPrepend2">facilite.com.br/</span>
                                                            </div>
                                                            <input type="text" class="form-control block-plaintext" name="des_slug" readonly disabled id="slugUsr" value="<?php if($usuario != NULL){echo $usuario->getSlugUsuario();} ?>">
                                                        </div>
                                                    </div>
                                                    <div class="pull-left" style="margin-top:0px;">    
                                                        <button type="button" id="btn-cancelEditSlug" class="btn btn-link d-none text-danger">Cancelar</button>
                                                        <button type="button" id="btn-editSlug" class="btn btn-link" style="">Editar</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="margin-top: 5px;">
                                                        <label for="nomeUsr">Nome Completo:</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control-plaintext" readonly disabled name="des_nome" id="nomeUsr" value="<?php if($usuario != NULL){echo $usuario->getNomeUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-top:0px;">    
                                                        <button type="button" id="btn-cancelEditNome" class="btn btn-link d-none text-danger">Cancelar</button>    
                                                        <button type="button" id="btn-editNome" class="btn btn-link" style="">Editar</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="text-align: left;margin-top: 5px;" for="emailUsr">Email</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <form style="margin:0px">
                                                            <input type="email" class="form-control-plaintext" readonly disabled name="des_email" id="emailUsr" value="<?php if($usuario != NULL){echo $usuario->getEmailUsuario();} ?>">
                                                        </form>
                                                    </div>
                                                    <div class="pull-left" style="margin-top:0px;">    
                                                        <button type="button" id="btn-cancelEditEmail" class="btn btn-link d-none text-danger">Cancelar</button>                                                                
                                                        <button type="button" id="btn-editEmail" class="btn btn-link" style="">Editar</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="margin-top: 5px;">
                                                        <label for="ocupUsr">Ocupação:</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control-plaintext" readonly disabled name="des_ocupacao" id="ocupUsr" value="<?php if($usuario != NULL){echo $usuario->getOcupacaoUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-top:0px;">    
                                                        <button type="button" id="btn-cancelEditOcupacao" class="btn btn-link d-none text-danger">Cancelar</button>    
                                                        <button type="button" id="btn-editOcupacao" class="btn btn-link" style="">Editar</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="margin-top: 5px;">
                                                        <label for="telUsr">Celular</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control-plaintext" readonly disabled name="des_telefone" id="telUsr" value="<?php if($usuario != NULL){echo $usuario->getTelefoneUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-top:0px;">    
                                                        <button type="button" id="btn-cancelEditTel" class="btn btn-link d-none text-danger">Cancelar</button>    
                                                        <button type="button" id="btn-editTel" class="btn btn-link" style="">Editar</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="margin-top: 5px;">
                                                        <label for="cpfUsr">CPF</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control-plaintext" readonly disabled name="des_cpf" id="cpfUsr" value="<?php if($usuario != NULL){echo $usuario->getCpfUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-top:0px;">    
                                                        <button type="button" id="btn-cancelEditCpf" class="btn btn-link d-none text-danger">Cancelar</button>
                                                        <button type="button" id="btn-editCpf" class="btn btn-link" style="">Editar</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="text-align: left;margin-top: 5px;" for="dtNascUsr">Data Nascimento</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="date" class="form-control-plaintext" readonly disabled name="dt_nasc" id="dtNascUsr" value="<?php if($usuario != NULL){echo $usuario->getDtNascUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-top:0px;">    
                                                        <button type="button" id="btn-cancelEditDtNasc" class="btn btn-link d-none text-danger">Cancelar</button>                                                                
                                                        <button type="button" id="btn-editDtNasc" class="btn btn-link" style="">Editar</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label style="text-align: left;margin-top: 5px;" for="sexoUsr">Sexo</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control-plaintext" readonly disabled name="des_sexo" id="sexoUsr">
                                                            <option ><?php if($usuario != NULL){echo $usuario->getSexoUsuario();} ?></option>
                                                            <?php if($usuario->getSexoUsuario() != "Feminino"){ ?> <option value="F">Feminino</option> <?php } ?>
                                                            <?php if($usuario->getSexoUsuario() != "Masculino"){ ?> <option value="M">Masculino</option> <?php } ?>
                                                            <?php if($usuario->getSexoUsuario() != ""){ ?> <option value="P">Prefiro não informar </option> <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="pull-left" style="margin-top:0px;">    
                                                        <button type="button" id="btn-cancelEditSexo" class="btn btn-link d-none text-danger">Cancelar</button>    
                                                        <button type="button" id="btn-editSexo" class="btn btn-link" style="">Editar</button>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3">
                                                        <label for="cidadeUser" style="margin-top:5px">Cidade</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control-plaintext" readonly disabled name="des_cidade" id="cidadeUsr" value="<?php if($usuario != NULL){echo $usuario->getCidadeUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-top:0px;">    
                                                        <button type="button" id="btn-cancelEditCidade" class="btn btn-link d-none text-danger">Cancelar</button>    
                                                        <button type="button" id="btn-editCidade" class="btn btn-link" style="">Editar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
                    </div></div>
                    <div class="col-md-3" style="padding:20px;">
                        <div class="row">
                            <div class="col-md-12  profile-card" style="padding:25px;">
                                <!-- SOBRE -->
                                <div class="col-12 clearfix text-center" style="margin-top:0px">
                                    <span class="stars-profile">
                                        <a>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half"></i>
                                        </a>
                                    </span>
                                </div>
                                <div class="col-12 numbers-card" style="margin-top:20px;">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <span style="font-size: 22px;font-weight:500;color:#3d4347">25</span>
                                            <p style="margin-top:-5px;margin-bottom:0px;color:#a6a9ac;font-weight:200">Concluídos</p>
                                        </div>
                                        <div class="col-4">
                                            <span style="font-size:22px;font-weight:500;color:#3d4347">20</span>
                                            <p style="margin-top:-5px;margin-bottom:0px;color:#a6a9ac;font-weight:200">Avaliações</p>
                                        </div>
                                        <div class="col-4">
                                            <button class="btn d-print-none btn-fc-primary btn-radius" style="padding:0px;margin-top:5px; height:40px; width:40px; margin-left:5px;" data-toggle="tooltip" data-placement="top" title="Compartilhar"><i class="fa fa-share"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row text-center">
                                        <?php if(isset($_SESSION['id'])){
                                        if($loggedUser->getIdUsuario() != $usuario->getIdUsuario()){
                                            $ligacoes= new Ligacao(); 
                                            $ligacoes = $ligacoes->loadById($loggedUser->getIdUsuario(),$usuario->getIdUsuario()); 
                                            ?>
                                            <button class="col-12 d-print-none btn btn-fc-<?php if($ligacoes == NULL){echo 'primary';}else{echo 'danger';} ?> open-Login btn-radius" id="criar-conexao" style="padding:7px;margin-top:10px;"<?php if(!isset($_SESSION['id'])||($_SESSION['id'] == $usuario->getidUsuario())){ echo 'disabled'; } ?>><?php if($ligacoes == NULL){echo ' Adicionar';}else{echo ' Remover';} ?>  Contato</button>
                                        <?php }}else{ ?>
                                            <button class="col-12 d-print-none btn btn-fc-primary open-Login btn-radius" style="padding:7px;margin-top:10px;"> Adicionar Contato</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>






                    <?php $ligacoes = new Ligacao();
                $ligacoes = $ligacoes->loadByUser($usuario->getIdUsuario(), 3); 
                if(count($ligacoes)>0){ ?>
                    <div class="row d-print-none" style="margin-top: 25px;">
                        <div class="col-md-12">
                            <div class="col-12" style="padding:0px">
                                <div class="title-text-card clearfix">
                                    <h5 class="skills-title pull-left" style="font-weight:400;text-transform:uppercase">Contatos</h5>
                                </div>
                            </div>
                            <div class="col-12" style="padding:0px">
                                <div class="row">
                                    <?php $contatos = new Usuario();
                                    foreach ($ligacoes as $key => $value) { 
                                    $contato = $contatos->loadById($ligacoes[$key]->getIdContatoLigacao());?>
                                        <div class="col-md-12" style="margin-top: 5px;margin-bottom: 10px;">
                                            <div class="row clearfix">
                                                <div class="col-2">
                                                    <img src="view/_img/profile/<?php echo $contato->getFotoUsuario(); ?>" alt="" class="rounded-circle" height="50">
                                                </div>
                                                <div class="col-10" style="padding-left:30px;">
                                                    <a href="<?php echo $contato->getSlugUsuario(); ?>" class="nome-contato"><h6 style="font-weight:400;margin-bottom:3px;margin-top:3px"><?php echo $contato->getNomeSimplesusuario(); ?> -<i class="fa fa-star" style="margin-left:5px;font-size: 15px;color:rgb(255, 208, 0)"></i> 9,2</h6></a>
                                                    <span class="pull-left stars">
                                                        <a style="font-size:14px;color:#8b8b8b"><?php echo substr($contato->getOcupacaoUsuario(),0,100); ?></a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>        
        </div>
    </section>








<?php if((isset($_SESSION['id']))&&($_SESSION['id'] == $usuario->getIdUsuario())){ ?>
<!-- Modal Adicionar Experiência -->
<div class="modal fade" id="addExperienciaModal" tabindex="-1" role="dialog" aria-labelledby="addExperienciaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document" style="">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-body">
                        <h4>Adicionar Experiência</h4>
                        <div class="row">
                            <div class="col-12" style="display:none">
                                <input type="text" name="id_experiencia_modal" id="id_experiencia_modal" value="">
                            </div>
                            <div class="col-12">
                                <label for="des_nome">Titulo:</label>
                                <input class="form-control" type="text" name="des_titulo_experiencia" id="des_titulo_experiencia" placeholder="">
                            </div>
                            <div class="col-12" style="margin-top:10px">
                                <label for="des_email">Descrição:</label>
                                <textarea class="form-control" name="des_descricao_experiencia" id="des_descricao_experiencia" cols="30" rows="4" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-addExperiencia" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Formação -->
    <div class="modal fade" id="addFormacaoModal" tabindex="-1" role="dialog" aria-labelledby="addFormacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:400px;">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-body">
                        <h4>Adicionar Formação</h4>
                            <div class="row">
                                <div class="col-12">
                                    <label for="des_nome">Titulo:</label>
                                    <input class="form-control" type="text" name="des_titulo_formacao" id="des_titulo_formacao" placeholder="">
                                </div>
                                <div class="col-12" style="margin-top:10px">
                                    <label for="des_email">Descrição:</label>
                                    <textarea class="form-control" name="ades_descricao_formacao" id="des_descricao_formacao" cols="30" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-addFormacao" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Serviço -->
    <div class="modal fade" id="addServicoModal" tabindex="-1" role="dialog" aria-labelledby="addServicoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-body">
                        <h4>Adicionar Serviço</h4>
                            <div class="row">
                                <div class="col-12">
                                    <label for="">Categoria:</label>
                                    <select class="form-control" readonly name="" id="">
                                        <?php 
                                        $cat = $categorias->loadAll();
                                        foreach ($cat as $key => $value) { ?> 
                                        <option><?php echo $cat[$key]->getDescricaoCategoria(); ?></option> 
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12" style="margin-top:10px">
                                    <label for="des_email">Descrição:</label>
                                    <textarea class="form-control" name="ades_descricao_formacao" id="des_descricao_formacao" cols="30" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
                                </div>
                                <div class="col-4" style="margin-top:10px">
                                    <label for="des_email">Preço:</label>
                                    <input class="form-control" type="text" name="des_titulo_formacao" id="des_titulo_formacao" placeholder="">
                                </div>
                                <div class="col-4" style="margin-top:10px">
                                    <label for="des_email">Modalidade:</label>
                                    <input class="form-control" type="text" name="des_titulo_formacao" id="des_titulo_formacao" placeholder="">
                                </div>
                                <div class="col-4" style="margin-top:10px">
                                    <label for="des_email">Disponibilidade:</label>
                                    <input class="form-control" type="text" name="des_titulo_formacao" id="des_titulo_formacao" placeholder="">                                    
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btn-addFormacao" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<?php include_once('_includes'.DS.'footer.php'); ?>
<script src="view/_js/profile.js"></script>
<script>
    $('.open-Login').click(function(e){
        e.stopPropagation();
        $('#dropdownMenu2').dropdown('toggle');
    });
</script>
</html>