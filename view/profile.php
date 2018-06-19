<?php
    require_once('../autoload.php');
    $uri = explode('/', $_SERVER["REQUEST_URI"]);
    $slug = str_replace("@","",$uri[count($uri)-1]);

    $infoUsuario = new Usuario();
    $usuario = $infoUsuario->loadBySlug($slug) ?? header('location:404');
    
    $pg_title = $usuario->getNomeSimplesUsuario() . ' - ';
    include_once('_includes'.DS.'header.php');

    $donoPerfil = false;
    if(isset($_SESSION['id'])&&($_SESSION['id'] == $usuario->getIdUsuario())){
        $donoPerfil = true;
    }
?>
    <input type="text" value="<?php if(isset($loggedUser)){echo $loggedUser->getIdUsuario();} ?>" id="id_usuario_logado" class="d-none">
    <section class="container-fluid" style="" id="profile-page">
        <div class="row d-print-none">
            <div class="col-md-12 " style="padding:5px;margin:0px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb" style="background-color:#fff;">
                        <li class="breadcrumb-item"><a href="home">Início</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo $usuario->getNomeSimplesUsuario(); ?></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row" style="margin-top:-30px;">
            <div class="col-md-3" style="padding:20px;">
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
                            <h5 class="text-center"><span class="profile-name"><?php echo $usuario->getNomeSimplesUsuario(); ?></span> <span style="font-size:15px;font-weight:normal">-<i class="fa fa-star" style="margin-left:5px;font-size: 18px;color:rgb(255, 208, 0)"></i> 4,2</span></h5>

                            <div class="text-center">
                                <p style="margin-top:-5px;font-size:14px;"><span id="sideOcupacao"><?php echo $usuario->getOcupacaoUsuario(); ?></span></p>
                                <?php if((isset($_SESSION['id']))&&($_SESSION['id'] != $usuario->getidUsuario())){ ?>
                                    <button class="btn btn-fc-primary btn-radius btn-rounded d-print-none" style="margin-bottom:10px;">Entrar em Contato</button>
                                <?php }else if(!isset($_SESSION['id'])){ ?>
                                    <button class="btn btn-fc-primary btn-radius d-print-none open-Login" style="margin-bottom:10px;">Entrar em Contato</button>
                                <?php } ?>
                            </div>

                            <div class="list-infos">
                                <div class="row">
                                    <p class="sub"><i class="fa fa-at"></i> <span><?php if($usuario != NULL){echo $usuario->getSlugUsuario();} ?></span></p>
                                    <p class="sub"><i class="fa fa-users"></i><span id="sideSexo">
                                        <?php if(!is_null($usuario->getSexoUsuario())){ 
                                            echo $usuario->getSexoUsuario().', ';  
                                        } ?>
                                        </span> <span id="sideIdade"><?php echo $usuario->getIdadeUsuario().' anos'; ?></span>
                                    </p>
                                    <?php if(!is_null($usuario->getCidadeUsuario())){ ?>
                                        <p class="sub"><i class="fa fa-map-marker" style="margin-left: 3px;margin-right: 8px;"></i><?php echo $usuario->getCidadeUsuario(); ?></p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-md-12  profile-card" style="padding:25px;">
                    <!-- SOBRE -->
                        <div class="col-12 numbers-card" style="margin-top:0px;">
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
            </div>
            

            <div class="col-md-6">
                <div class="row" style="margin-top:0px">
                    <div class="col-md-12" id="visao-geral">
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
                                        <div class="clearfix">
                                            <div class="col-12">
                                                <p class="pull-left" style="width:auto;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="far fa-address-card" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:10px"></i> Sobre</p>
                                                <?php if($donoPerfil){ ?>
                                                    <div class="clearfix">
                                                        <button type="button" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:13px;margin-bottom:-15px;" data-toggle="modal" data-target="#editApresentacaoModal"><i class="fa fa-edit" style="margin-right:5px;"></i>Editar</button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div id="apresentacao">  
                                            <div class="col-12">
                                                <div style="margin-top:25px;margin-bottom:15px">
                                                    <div class="clearfix">
                                                        <input type="text" style="position:absolute; display:none" id="id_usuario" value="<?php echo $usuario->getIdUsuario(); ?>">
                                                        <?php if(($usuario->getApresentacaoUsuario() != '')&&($usuario->getApresentacaoUsuario() != NULL)){ ?>
                                                            <p id="des_apresentacao" style="margin-top:5px;margin-left:-7px;margin-right:-10px;font-weight:300"><?php echo $usuario->getApresentacaoUsuario(); ?></p>
                                                        <?php }else{ ?>
                                                            <p id="des_apresentacao" style="margin-top:5px;margin-left:-7px;margin-right:-10px;font-weight:300">Olá, eu sou novo aqui. :)</p>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        
                                        

                                        <?php $experiencias = new Experiencia();
                                        $experiencias = $experiencias->loadByUser($usuario->getIdUsuario());
                                        if(($donoPerfil)||(count($experiencias)>0)){ ?>
                                        <div class="clearfix" style="margin-bottom:20px;">
                                            <div class="col-12">
                                                <p class="pull-left" style="width:auto;margin-top: 30px;margin-bottom:10px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-suitcase" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:10px"></i> Experiências</p>
                                                <?php if($donoPerfil){ ?>
                                                    <div class="clearfix">
                                                        <button type="button" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:28px;margin-bottom:-15px;" data-toggle="modal" data-target="#addExperienciaModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                    </div>
                                                <?php } ?> 
                                            </div>
                                        </div>
                                        <div id="experiencias-itens">
                                            
                                            <?php foreach ($experiencias as $key => $value) { ?>
                                                <div class="col-12">
                                                    <div class="clearfix">
                                                        <input type="text" class="id_experiencia d-none" value="<?php echo $experiencias[$key]->getIdExperiencia(); ?>">
                                                        <div class="row clearfix">
                                                            <p class="des_titulo_experiencia col-11" style="width:auto; margin-left:-5px;font-weight:400; font-size:17px;margin-bottom:0px"><?php echo $experiencias[$key]->getTituloExperiencia(); ?></p>
                                                            <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getidUsuario()){ ?>
                                                            <div class="btn-group col-1">
                                                                <button type="button" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <button class="btn-editExperiencia dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                    <button class="btn-delExperiencia text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                </div>
                                                            </div>
                                                            <?php }} ?>
                                                        </div>
                                                        <p class="col-12 desc des_descricao_experiencia" style="margin-left:-10px;margin-right:-10px; padding-left:5px;font-weight:300;font-size:16px;color:#a0a5b5"><?php echo $experiencias[$key]->getDescricaoExperiencia(); ?></p>
                                                    </div>
                                                    <hr style="margin-left:-5px;margin-right:-5px">
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>

                                        <?php $formacoes = new Formacao();
                                        $formacoes = $formacoes->loadByUser($usuario->getIdUsuario());
                                        if(($donoPerfil)||(count($formacoes)>0)){ ?>
                                        <div class="clearfix">
                                            <div class="col-12">
                                                <p class="pull-left" style="width:auto;margin-top: 30px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-trophy" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:10px"></i> Formação</p>
                                                <?php if($donoPerfil){ ?>
                                                    <div class="clearfix">
                                                        <button type="button" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:28px;margin-bottom:-15px;" data-toggle="modal" data-target="#addFormacaoModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div id="formacoes-itens" class="row" style="margin-top:30px;margin-left:0px;padding-right:15px;">
                                            <?php foreach ($formacoes as $key => $value) { ?>
                                                <div class="col-12">
                                                    <div class="clearfix">
                                                        <input type="text" class="id_formacao" value="<?php echo $formacoes[$key]->getIDFormacao(); ?>" style="display:none">
                                                        <div class="row clearfix">
                                                            <p class="des_titulo_formacao col-11" style="width:auto;margin-left:-5px;font-weight:400;font-size:17px;margin-bottom:0px;"><?php echo $formacoes[$key]->getTituloFormacao(); ?></p>
                                                            <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getidUsuario()){ ?>
                                                            <div class="btn-group col-1">
                                                                <button type="button" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <button class="btn-editFormacao dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                    <button class="btn-delFormacao text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                </div>
                                                            </div>
                                                            <?php }} ?>
                                                        </div>
                                                        <p class="desc des_descricao_formacao" id="des_apresentacao" style="margin-left:-5px;margin-right:-10px;margin-top:0px;font-weight:300;color:#a0a5b5"><?php echo $formacoes[$key]->getDescricaoFormacao(); ?></p>
                                                    </div>
                                                    <hr style="margin-left:-5px;margin-right:-5px">
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                        

                                        <?php $habilidades = new Habilidade();
                                        $habilidades = $habilidades->loadByUser($usuario->getIdUsuario());
                                        if(($donoPerfil)||(count($habilidades)>0)){ ?>
                                        <div class="clearfix">
                                            <div class="col-12">
                                                <p class="pull-left" style="width:auto;margin-left:17px;margin-top: 30px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-lightbulb" style="margin-left:-20px;font-size:20px;color:#60686e;margin-right:10px"></i> Habilidades</p>
                                                <?php if($donoPerfil){ ?>
                                                    <div class="clearfix">
                                                        <button type="button" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:25px;margin-bottom:-15px;padding-left:10px;padding-right:10px" data-toggle="modal" data-target="#addHabilidadeModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                    </div>
                                                <?php } ?> 
                                            </div>
                                        </div>
                                        <div style="margin-top:0px">
                                            <div id="habilidades-itens" class="row" style="margin-left:10px;margin-top:20px;margin-bottom:30px;">
                                                <?php foreach ($habilidades as $key => $value) { ?>
                                                    <span id="<?php echo $habilidades[$key]->getIdHabilidade(); ?>" class="skills-label"><?php echo $habilidades[$key]->getDescricaoHabilidade(); ?><?php if($donoPerfil){ ?><i class="fa fa-times-circle btn-delHabilidade" style="margin-left:10px;cursor:pointer"></i><?php } ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    
                                    <div id="servicos" class="tab-pane fade">
                                        <div class="clearfix">
                                            <p class="pull-left" style="width:auto;margin-left:12px;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-globe" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:10px"></i> Serviços</p>
                                            <?php if($donoPerfil){ ?>
                                                <div class="pull-right">
                                                    <div class="clearfix">
                                                        <button type="button" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-bottom:-15px;margin-right:15px;margin-top:10px" data-toggle="modal" data-target="#addServicoModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                    </div>
                                                </div>
                                            <?php } ?> 
                                        </div>
                                        
                                        
                                        <div id="servicos-itens" style="margin-top:35px">
                                            <?php $categorias = new Categoria();
                                            $modalidades = new Modalidade();
                                            //   $servicos = new Servicos();
                                            $anuncios = new Anuncio();
                                            $anuncio = $anuncios->loadByUser($usuario->getidUsuario()); 
                                            foreach ($anuncio as $key => $value) { 
                                                $categoria = $categorias->loadById($anuncio[$key]->getIdCategoriaAnuncio());
                                                $modalidade = $modalidades->loadById($anuncio[$key]->getIdModalidadeAnuncio());
                                            ?>

                                            <div class="col-12 clearfix" style="margin-bottom:5px">
                                                <input type="text" class="d-none id_servico" value="<?php echo $anuncio[$key]->getIdAnuncio(); ?>">
                                                <div class="row clearfix">
                                                    <p class="des_categoria_servico col-11" id="<?php echo $categoria->getIdCategoria(); ?>" style="width:auto; margin-left:-5px;font-weight:400; padding-right:25px;font-size:17px;margin-bottom:0px"><?php echo $categoria->getDescricaoCategoria(); ?></p>
                                                    <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getidUsuario()){ ?>
                                                    <div class="btn-group col-1">
                                                        <button type="button" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <button class="btn-editServico dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                            <button class="btn-delServico text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                        </div>
                                                    </div>
                                                    <?php }} ?>
                                                </div>
                                                
                                                <p class="col-12 desc des_descricao_servico" style="margin-left:-10px;margin-right:-10px; padding-left:5px;padding-bottom:1px;padding-top:10px;font-weight:300;font-size:16px;"><?php echo $anuncio[$key]->getDescricaoAnuncio(); ?></p>
                                                <p class="desc" style="margin-left:-5px">Preço: R$ <span class="des_preco_servico"><?php echo $anuncio[$key]->getPrecoAnuncio(); ?></span><span class="des_modalidade_servico" id="<?php echo $modalidade->getIdModalidade(); ?>" style="margin-right:15px"> <?php echo $modalidade->getDescricaoModalidade(); ?></span>
                                                
                                                Disponibilidade: <span class="des_disponibilidade_servico"><?php echo $anuncio[$key]->getDisponibilidadeAnuncio(); ?></span></p>                                                        
                                                <hr style="margin-left:-5px;margin-right:-5px">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php if($donoPerfil){ ?>
                                <div id="cadastro" class="tab-pane fade">
                                    <div class="col-12" style="min-height:25px; margin-top:20px;padding-left:5px;" >
                                        <div class="pull-left">
                                            <h6 class="skills-title">Suas Informações</h6>
                                        </div>
                                    </div>
                                    <div class="col-12" style="margin-left:0px; max-width:96%;margin-top:15px;padding-right:0px">
                                            <div class="form-group" style="margin:0px;">
                                                <div class="row" style="margin-top: 10px;margin-right:0px;">
                                                    <div class="col-md-3" style="padding-left:5px;padding-right:0px;">
                                                        <label for="slugUsr" style="margin-top: 5px;">Nome de Usuário</label>
                                                    </div>
                                                    <div class="col-md-6" style="padding-right:0px;padding-left:5px;margin-right:10px;">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="inputGroupPrepend2">faciliteserv.com/</span>
                                                            </div>
                                                            <input type="text" class="form-control block-plaintext" name="des_slug" readonly disabled id="slugUsr" value="<?php if($usuario != NULL){echo $usuario->getSlugUsuario();} ?>">
                                                        </div>
                                                    </div>
                                                    <div class="pull-left" style="margin-left:5px;margin-top:10px;">
                                                        <a class="btn-link d-none text-danger" id="btn-cancelEditSlug" style="cursor:pointer;margin-right:10px">Cancelar</a>
                                                        <a class="btn-link" id="btn-editSlug" style="color:#007bff;cursor:pointer;margin-right:10px">Editar</a>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 20px;">
                                                    <div class="col-md-3" style="padding-left:5px;padding-right:5px;margin-top:5px">
                                                        <label for="nomeUsr">Nome Completo</label>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left:5px;">
                                                        <input type="text" class="form-control-plaintext" readonly disabled name="des_nome" id="nomeUsr" value="<?php if($usuario != NULL){echo $usuario->getNomeUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-left:5px;margin-top:10px;">
                                                        <a class="btn-link d-none text-danger" id="btn-cancelEditNome" style="cursor:pointer;margin-right:10px">Cancelar</a>
                                                        <a class="btn-link" id="btn-editNome" style="color:#007bff;cursor:pointer;margin-right:10px">Editar</a>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="padding-left:5px;padding-right:5px;">
                                                        <label style="text-align: left;margin-top: 5px;" for="emailUsr">Email</label>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left:5px;">
                                                        <form style="margin:0px">
                                                            <input type="email" class="form-control-plaintext" readonly disabled name="des_email" id="emailUsr" value="<?php if($usuario != NULL){echo $usuario->getEmailUsuario();} ?>">
                                                        </form>
                                                    </div>
                                                    <div class="pull-left" style="margin-left:5px;margin-top:10px;">   
                                                        <a class="btn-link d-none text-danger" id="btn-cancelEditEmail" style="cursor:pointer;margin-right:10px">Cancelar</a>
                                                        <a class="btn-link" id="btn-editEmail" style="color:#007bff;cursor:pointer;margin-right:10px">Editar</a>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="padding-left:5px;padding-right:5px;">
                                                        <label for="ocupUsr" style="margin-top: 5px;">Ocupação</label>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left:5px;">
                                                        <input type="text" class="form-control-plaintext" readonly disabled name="des_ocupacao" id="ocupUsr" value="<?php if($usuario != NULL){echo $usuario->getOcupacaoUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-left:5px;margin-top:10px;">     
                                                        <a class="btn-link d-none text-danger" id="btn-cancelEditOcupacao" style="cursor:pointer;margin-right:10px">Cancelar</a>
                                                        <a class="btn-link" id="btn-editOcupacao" style="color:#007bff;cursor:pointer;margin-right:10px">Editar</a>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="padding-left:5px;padding-right:5px;">
                                                        <label for="telUsr" style="margin-top: 5px;">Celular</label>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left:5px;">
                                                        <input type="text" class="form-control-plaintext" readonly disabled name="des_telefone" id="telUsr" value="<?php if($usuario != NULL){echo $usuario->getTelefoneUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-left:5px;margin-top:10px;">     
                                                        <a class="btn-link d-none text-danger" id="btn-cancelEditTel" style="cursor:pointer;margin-right:10px">Cancelar</a>
                                                        <a class="btn-link" id="btn-editTel" style="color:#007bff;cursor:pointer;margin-right:10px">Editar</a>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="padding-left:5px;padding-right:5px;">
                                                        <label for="cpfUsr" style="margin-top: 5px;">CPF</label>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left:5px;">
                                                        <input type="text" class="form-control-plaintext" readonly disabled name="des_cpf" id="cpfUsr" value="<?php if($usuario != NULL){echo $usuario->getCpfUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-left:5px;margin-top:10px;">     
                                                        <a class="btn-link d-none text-danger" id="btn-cancelEditCpf" style="cursor:pointer;margin-right:10px">Cancelar</a>
                                                        <a class="btn-link" id="btn-editCpf" style="color:#007bff;cursor:pointer;margin-right:10px">Editar</a> 
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="padding-left:5px;">
                                                        <label style="text-align: left;margin-top: 5px;" for="dtNascUsr">Aniversário</label>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left:5px;">
                                                        <input type="date" class="form-control-plaintext" readonly disabled name="dt_nasc" id="dtNascUsr" value="<?php if($usuario != NULL){echo $usuario->getDtNascUsuario();} ?>">
                                                    </div>
                                                    <div class="pull-left" style="margin-left:5px;margin-top:10px;">     
                                                        <a class="btn-link d-none text-danger" id="btn-cancelEditDtNasc" style="cursor:pointer;margin-right:10px">Cancelar</a>
                                                        <a class="btn-link" id="btn-editDtNasc" style="color:#007bff;cursor:pointer;margin-right:10px">Editar</a>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="padding-left:5px;">
                                                        <label style="text-align: left;margin-top: 5px;" for="sexoUsr">Sexo</label>
                                                    </div>
                                                    <div class="col-md-6" style="padding-left:5px;">
                                                        <select class="form-control-plaintext" readonly disabled name="des_sexo" id="sexoUsr">
                                                            <option ><?php if($usuario != NULL){echo $usuario->getSexoUsuario();} ?></option>
                                                            <?php if($usuario->getSexoUsuario() != "Feminino"){ ?> <option value="F">Feminino</option> <?php } ?>
                                                            <?php if($usuario->getSexoUsuario() != "Masculino"){ ?> <option value="M">Masculino</option> <?php } ?>
                                                            <?php if($usuario->getSexoUsuario() != ""){ ?> <option value="P">Prefiro não informar </option> <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="pull-left" style="margin-left:5px;margin-top:10px;">     
                                                        <a class="btn-link d-none text-danger" id="btn-cancelEditSexo" style="cursor:pointer;margin-right:10px">Cancelar</a>
                                                        <a class="btn-link" id="btn-editSexo" style="color:#007bff;cursor:pointer;margin-right:10px">Editar</a>  
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-3" style="padding-left:5px;">
                                                        <label for="cidadeUser" style="margin-top:5px">Cidade</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select class="form-control-plaintext" readonly disabled name="des_cidade" id="cidadeUsr">
                                                            <?php $infos = new Usuario(); 
                                                            $cidades = $infos->loadCity(); 
                                                            foreach ($cidades as $key => $value) { ?>
                                                                <option value="<?php echo $cidades[$key]['id_cidade']; ?>"><?php echo $cidades[$key]['des_nome']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="pull-left" style="margin-left:5px;margin-top:10px;">     
                                                        <a class="btn-link d-none text-danger" id="btn-cancelEditCidade" style="cursor:pointer;margin-right:10px">Cancelar</a>
                                                        <a class="btn-link" id="btn-editCidade" style="color:#007bff;cursor:pointer;margin-right:10px">Editar</a>  
                                                    </div>
                                                </div>
                                                <hr style="margin-left:-10px; margiin-right:-10px">
                                                <a id="delete-account" class="text-danger btn-link" style="cursor:pointer; margin-left:-10px;">Deletar minha conta</a>
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
                <?php $ligacoes = new Ligacao();
                $ligacoes = $ligacoes->loadByUser($usuario->getIdUsuario(), 3); ?>
                <div class="row d-print-none" style="margin-top: 15px;">
                    <div class="col-md-12">
                        <div class="col-12" style="padding:0px">
                            <div class="title-text-card clearfix">
                                <h5 class="skills-title pull-left" style="font-weight:400;text-transform:uppercase">Contatos</h5>
                            </div>
                        </div>
                        <div class="col-12" style="padding:0px">
                            <div class="row">
                                <?php if(count($ligacoes)>0){
                                $contatos = new Usuario();
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
                                <?php }
                                }else{ ?>   
                                    <div class="col-md-12" style="margin-top: 5px;margin-bottom: 10px;color:#8b8b8b">
                                        Nenhum Contato
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </section>
















<?php if((isset($_SESSION['id']))&&($_SESSION['id'] == $usuario->getIdUsuario())){ ?>
    <!-- Modal Editar Apresnetacao -->
    <div class="modal fade" id="editApresentacaoModal" tabindex="-1" role="dialog" aria-labelledby="editApresentacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:400px;">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <form action="" method="POST">
                    <div class="modal-body">
                        <h4>Apresentação</h4>
                            <div class="row">
                                <div class="col-12" style="margin-top:10px">
                                    <label for="des_email">Sobre você:</label>
                                    <textarea class="form-control" name="des_apresentacao_modal" id="des_apresentacao_modal" cols="30" rows="5" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-editApresentacao" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Adicionar Experiência -->
    <div class="modal fade" id="addHabilidadeModal" tabindex="-1" role="dialog" aria-labelledby="addHabilidadeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document" style="">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <form action="" method="POST">
                    <div class="modal-body">
                        <h4>Adicionar Habilidade</h4>
                        <div class="row">
                            <div class="col-12">
                                <label for="des_nome">Habilidade:</label>
                                <select class="form-control" readonly name="des_habilidade_modal" id="des_habilidade_modal">
                                        <?php 
                                        $hab = new Habilidade();
                                        $hab = $hab->loadAll();
                                        foreach ($hab as $key => $value) { ?> 
                                        <option value="<?php echo $hab[$key]->getIdHabilidade(); ?>"><?php echo $hab[$key]->getDescricaoHabilidade(); ?></option> 
                                        <?php } ?>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-addHabilidade" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Adicionar Experiência -->
    <div class="modal fade" id="addExperienciaModal" tabindex="-1" role="dialog" aria-labelledby="addExperienciaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document" style="">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
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
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <form action="" method="POST">
                    <div class="modal-body">
                        <h4>Adicionar Formação</h4>
                            <div class="row">
                                <div class="col-12" style="display:none">
                                    <input type="text" name="id_formacao_modal" id="id_formacao_modal" value="">
                                </div>
                                <div class="col-12">
                                    <label for="des_nome">Titulo:</label>
                                    <input class="form-control" type="text" name="des_titulo_formacao" id="des_titulo_formacao" placeholder="">
                                </div>
                                <div class="col-12" style="margin-top:10px">
                                    <label for="des_email">Descrição:</label>
                                    <textarea class="form-control" name="des_descricao_formacao" id="des_descricao_formacao" cols="30" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
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
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <form action="" method="POST">
                    <div class="modal-body">
                        <h4>Adicionar Serviço</h4>
                            <div class="row">
                            <div class="col-12" style="display:none">
                                    <input type="text" name="id_servico_modal" id="id_servico_modal" value="">
                                </div>
                                <div class="col-12">
                                    <label for="">Categoria:</label>
                                    <select class="form-control" readonly name="des_categoria_servico" id="des_categoria_servico">
                                        <?php 
                                        $cat = $categorias->loadAll();
                                        foreach ($cat as $key => $value) { ?> 
                                        <option value="<?php echo $cat[$key]->getIdCategoria(); ?>"><?php echo $cat[$key]->getDescricaoCategoria(); ?></option> 
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12" style="margin-top:10px">
                                    <label for="des_email">Descrição:</label>
                                    <textarea class="form-control" name="des_descricao_servico" id="des_descricao_servico" cols="30" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
                                </div>
                                <div class="col-6 col-md-4" style="margin-top:10px">
                                    <label for="des_email">Preço:</label>
                                    <input class="form-control" type="text" name="des_preco_servico" id="des_preco_servico" placeholder="">
                                </div>
                                <div class="col-6 col-md-4" style="margin-top:10px">
                                    <label for="">Modalidade:</label>
                                    <select class="form-control" readonly name="des_modalidade_servico" id="des_modalidade_servico">
                                        <?php 
                                        $mod = $modalidades->loadAll();
                                        foreach ($mod as $key => $value) { ?> 
                                        <option value="<?php echo $cat[$key]->getIdCategoria(); ?>"><?php echo $mod[$key]->getDescricaoModalidade(); ?></option> 
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-4" style="margin-top:10px">
                                    <label for="des_email">Disponibilidade:</label>
                                    <input class="form-control" type="text" name="des_disponibilidade_servico" id="des_disponibilidade_servico" placeholder="">                                    
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-addServico" class="btn btn-success col-12">Salvar</button>
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