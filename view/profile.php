<?php
    require('../autoload.php');
    $uri = explode('/', $_SERVER["REQUEST_URI"]);
    $slug = str_replace("@","",$uri[count($uri)-1]);

    $anuncio = new Anuncio();
    $ligacao = new Ligacao();
    $user = new Usuario();
    $usuario = $user->loadBySlug($slug) ?? header('location:erro');
    
    $pg_title = $usuario->getNomeSimplesUsuario() . ' - ';
    $description = $usuario->getApresentacaoUsuario();
    include('_includes'.DS.'header.php');

    $donoPerfil = false;
    if(isset($_SESSION['id'])&&($_SESSION['id'] == $usuario->getIdUsuario())){
        $donoPerfil = true;
    }

     
?>
    <div id="content">
        <input type="text" value="<?php if(isset($loggedUser)){echo $loggedUser->getIdUsuario();} ?>" id="id_usuario_logado" class="d-none">
        <section class="container-fluid" style="" id="profile-page">
            
            <div class="row">
                <div class="col-md-3" style="padding:20px;">
                    <div class="row d-print-none">
                        <div class="col-md-12 " style="padding:0px;margin:0px;margin-bottom:-5px">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb" style="background-color:#fff;border-radius:0px">
                                    <li class="breadcrumb-item"><a aria-label="inicio" href="home">Início</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?php echo $usuario->getNomeSimplesUsuario(); ?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>


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
                                        <button aria-label="entrar em contato" class="btn btn-fc-primary btn-radius d-print-none" style="margin-bottom:10px;">entrar em Contato</button>
                                    <?php }else if(!isset($_SESSION['id'])){ ?>
                                        <a href="identifique-se" aria-label="entrar em contato" class="btn btn-fc-primary btn-radius d-print-none" style="margin-bottom:10px;">entrar em Contato</a>
                                    <?php } ?>
                                </div>
                                
                                <hr style="margin-left:-20px;margin-right:-20px">
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
                            
                        <hr style="margin-left:-20px;margin-right:-20px">
                            <div class="col-12 numbers-card">
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
                                        <button aria-label="Compartilhar perfil de <?php echo $usuario->getNomeSimplesUsuario(); ?>" class="btn d-print-none btn-fc-primary btn-radius"  style="padding:0px;margin-top:5px; height:40px; width:40px; margin-left:5px;" data-toggle="tooltip" data-placement="top" title="Compartilhar"><i class="fa fa-share"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row text-center">
                                    <?php if(isset($_SESSION['id'])){
                                    if(!$donoPerfil){
                                        $ligacoes = $ligacao->loadById($loggedUser->getIdUsuario(),$usuario->getIdUsuario()); 
                                    ?>
                                        <button aria-label="Adicionar <?php echo $usuario->getNomeSimplesUsuario(); ?> como contato" class="col-12 d-print-none btn btn-fc-<?php if(is_null($ligacoes)){echo 'primary';}else{echo 'danger';} ?> open-Login btn-radius" id="criar-conexao" style="padding:7px;margin-top:10px;"<?php if(!isset($_SESSION['id'])||($_SESSION['id'] == $usuario->getidUsuario())){ echo 'disabled'; } ?>><?php if(is_null($ligacoes)){echo ' Adicionar';}else{echo ' Remover';} ?>  Contato</button>
                                    <?php }}else{ ?>
                                        <a href="identifique-se" class="col-12 d-print-none btn btn-fc-primary btn-radius" aria-label="Adicionar <?php echo $usuario->getNomeSimplesUsuario(); ?> como contato" style="padding:7px;margin-top:10px;"> Adicionar Contato</a>
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
                                            <a aria-label="Visao geral" class="nav-link active" data-toggle="tab" href="#geral">Visão Geral</a>
                                        </li>
                                        <?php if((count($anuncio->loadByUser($usuario->getidUsuario()))>0)||((isset($_SESSION['id']))&&($_SESSION['id']==$usuario->getIdUsuario()))){ ?>
                                            <li class="nav-item d-print-none">
                                                <a aria-label="Serviços" class="nav-link" data-toggle="tab" href="#servicos">Serviços</a>
                                            </li>
                                        <?php } ?>
                                        <a href="configuracoes" class="pull-right" style="margin-top:7px;margin-left:20px">Configurações</a>
                                    </ul>

                                    <div class="tab-content" style="padding-top:20px;">
                                        <div id="geral" class="tab-pane fade active show">
                                            <div class="clearfix">
                                                <div class="col-12">
                                                    <p class="pull-left" style="width:auto;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="far fa-address-card" style="margin-left:-5px;font-size:20px;color:#60686e;margin-right:10px"></i> Sobre</p>
                                                    <?php if($donoPerfil){ ?>
                                                        <div class="clearfix">
                                                            <button type="button" aria-label="Editar apresentação" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:13px;margin-bottom:-15px;" data-toggle="modal" data-target="#editApresentacaoModal"><i class="fa fa-edit" style="margin-right:5px;"></i>Editar</button>
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
                                                            <button type="button" aria-label="Adicionar Experiência" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:28px;margin-bottom:-15px;" data-toggle="modal" data-target="#addExperienciaModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
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
                                                                    <button type="button" aria-label="Opções da experiência" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <button aria-label="Editar experiência" class="btn-editExperiencia dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                        <button aria-label="Deletar experiência" class="btn-delExperiencia text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                    </div>
                                                                </div>
                                                                <?php }} ?>
                                                            </div>
                                                            <p class="col-12 desc des_descricao_experiencia" style="margin-left:-10px;margin-right:-10px; padding-left:5px;font-weight:300;font-size:16px"><?php echo $experiencias[$key]->getDescricaoExperiencia(); ?></p>
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
                                                            <button type="button" aria-label="Adicionar nova formação" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:28px;margin-bottom:-15px;" data-toggle="modal" data-target="#addFormacaoModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
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
                                                                    <button aria-label="opções da formação" type="button" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <button aria-label="Editar formação" class="btn-editFormacao dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                        <button aria-label="Deletar formação" class="btn-delFormacao text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                    </div>
                                                                </div>
                                                                <?php }} ?>
                                                            </div>
                                                            <p class="desc des_descricao_formacao" style="margin-left:-5px;margin-right:-10px;margin-top:0px;font-weight:300;color:#a0a5b5"><?php echo $formacoes[$key]->getDescricaoFormacao(); ?></p>
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
                                                            <button type="button" aria-label="Adicionar nova Habilidade" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:25px;margin-bottom:-15px;padding-left:10px;padding-right:10px" data-toggle="modal" data-target="#addHabilidadeModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                        </div>
                                                    <?php } ?> 
                                                </div>
                                            </div>
                                            <div style="margin-top:0px">
                                                <div id="habilidades-itens" class="row" style="margin-left:10px;margin-top:20px;margin-bottom:30px;">
                                                    <?php foreach ($habilidades as $key => $value) { ?>
                                                        <span id="<?php echo $habilidades[$key]->getIdHabilidade(); ?>" class="skills-label"><?php echo $habilidades[$key]->getDescricaoHabilidade(); ?><?php if($donoPerfil){ ?><i class="fa fa-times-circle btn-delHabilidade" style="margin-left:10px;cursor:pointer" aria-label="Deletar habilidade"></i><?php } ?></span>
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
                                                            <button type="button" aria-label="Adicionar novo serviço" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-bottom:-15px;margin-right:15px;margin-top:10px" data-toggle="modal" data-target="#addServicoModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                        </div>
                                                    </div>
                                                <?php } ?> 
                                            </div>
                                            
                                            
                                            <div id="servicos-itens" style="margin-top:35px">
                                                <?php 
                                                $anuncio = $anuncio->loadByUser($usuario->getidUsuario()); 
                                                foreach ($anuncio as $key => $value) { ?>
                                                    <div class="col-12 clearfix" style="margin-bottom:5px">
                                                        <input type="text" class="d-none id_servico" value="<?php echo $anuncio[$key]->getIdAnuncio(); ?>">
                                                        <div class="row clearfix">
                                                            <p class="des_categoria_servico col-11" id="<?php echo $anuncio[$key]->getIdCategoriaAnuncio(); ?>" style="width:auto; margin-left:-5px;font-weight:400; padding-right:25px;font-size:17px;margin-bottom:0px"><?php echo $anuncio[$key]->getCategoriaAnuncio(); ?></p>
                                                            <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getidUsuario()){ ?>
                                                            <div class="btn-group col-1">
                                                                <button type="button" aria-label="Opções do serviço" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <button aria-label="Editar serviço" class="btn-editServico dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                    <button aria-label="Deletar serviço" class="btn-delServico text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                </div>
                                                            </div>
                                                            <?php }} ?>
                                                        </div>
                                                        
                                                        <p class="col-12 desc des_descricao_servico" style="margin-left:-10px;margin-right:-10px; padding-left:5px;padding-bottom:1px;padding-top:10px;font-weight:300;font-size:16px;"><?php echo $anuncio[$key]->getDescricaoAnuncio(); ?></p>
                                                        <p class="desc" style="margin-left:-5px">Preço: R$ <span class="des_preco_servico"><?php echo $anuncio[$key]->getPrecoAnuncio(); ?></span><span class="des_modalidade_servico" id="<?php echo $anuncio[$key]->getIdModalidadeAnuncio(); ?>" style="margin-right:15px"> <?php echo $anuncio[$key]->getModalidadeAnuncio(); ?></span>
                                                        
                                                        Disponibilidade: <span class="des_disponibilidade_servico"><?php echo $anuncio[$key]->getDisponibilidadeAnuncio(); ?></span></p>                                                        
                                                        <hr style="margin-left:-5px;margin-right:-5px">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div></div>
                        <div class="col-md-3" style="padding:20px;">
                    <?php $ligacoes = $ligacao->loadByUser($usuario->getIdUsuario(), 3); ?>
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
                                    foreach ($ligacoes as $key => $value) { 
                                    $contato = $user->loadById($ligacoes[$key]->getIdContatoLigacao());?>
                                        <div class="col-md-12" style="margin-top: 5px;margin-bottom: 10px;">
                                            <div class="row clearfix">
                                                <div class="col-2">
                                                    <img src="view/_img/profile/<?php echo $contato->getFotoUsuario(); ?>" alt="" class="rounded-circle" height="50">
                                                </div>
                                                <div class="col-10" style="padding-left:30px;">
                                                    <a aria-label="<?php echo $usuario->getNomeSimplesusuario(); ?>" href="<?php echo $contato->getSlugUsuario(); ?>" class="nome-contato"><h6 style="font-weight:400;margin-bottom:3px;margin-top:3px"><?php echo $contato->getNomeSimplesusuario(); ?> -<i class="fa fa-star" style="margin-left:5px;font-size: 15px;color:rgb(255, 208, 0)"></i> 9,2</h6></a>
                                                    <span class="pull-left stars">
                                                        <a aria-label="<?php echo substr($contato->getOcupacaoUsuario(),0,100); ?>" style="font-size:14px;color:#8b8b8b"><?php echo substr($contato->getOcupacaoUsuario(),0,100); ?></a>
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
    </div>
















<?php if((isset($_SESSION['id']))&&($_SESSION['id'] == $usuario->getIdUsuario())){ ?>
    <!-- Modal Editar Apresnetacao -->
    <div class="modal fade" id="editApresentacaoModal" tabindex="-1" role="dialog" aria-label="editApresentacaoModalLabel" aria-hidden="true">
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
                        <button type="button" aria-label="Salvar texto de apresentação." id="btn-editApresentacao" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Adicionar Experiência -->
    <div class="modal fade" id="addHabilidadeModal" tabindex="-1" role="dialog" aria-label="addHabilidadeModalLabel" aria-hidden="true">
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
                        <button type="button" aria-label="Salvar habilidade" id="btn-addHabilidade" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Adicionar Experiência -->
    <div class="modal fade" id="addExperienciaModal" tabindex="-1" role="dialog" aria-label="addExperienciaModalLabel" aria-hidden="true">
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
                        <button type="button" aria-label="Salvar experiência" id="btn-addExperiencia" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Formação -->
    <div class="modal fade" id="addFormacaoModal" tabindex="-1" role="dialog" aria-label="addFormacaoModalLabel" aria-hidden="true">
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
                        <button type="button" aria-label="Slavar formação" id="btn-addFormacao" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Serviço -->
    <div class="modal fade" id="addServicoModal" tabindex="-1" role="dialog" aria-label="addServicoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
            <?php $categorias = new Categoria();
                  $modalidades = new Modalidade(); ?>
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
                        <button type="button" aria-label="Salvar serviço" id="btn-addServico" class="btn btn-success col-12">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('_includes'.DS.'footer.php'); ?>
<script src="view/_js/profile.js"></script>
<script>
    $('.open-Login').click(function(e){
        e.stopPropagation();
        $('#dropdownMenu2').dropdown('toggle');
    });
</script>
</html>