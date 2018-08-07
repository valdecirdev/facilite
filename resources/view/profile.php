<?php

    use controller\{UsuarioController, HabilidadeController, LigacaoController, CategoriaController, ModalidadeController};
    use Carbon\Carbon;

    $uri = explode('/', $_SERVER["REQUEST_URI"]);
    $slug = str_replace("@","",$uri[count($uri)-1]);


    $user    = new UsuarioController();
    $ligacao = new LigacaoController();
    $usuario = $user->loadBySlug($slug) ?? header('location:erro');

    $nome = explode(' ', $usuario->getAttribute('des_nome'));
    $nomeSimpes = $nome[0] . ' ' . $nome[count($nome)-1];

    $pg_title = $nomeSimpes.' - ';
    $description = $usuario->getAttribute('des_apresentacao');
    include('_includes'.DS.'header.php');

    $donoPerfil = false;
    if(isset($_SESSION['id'])&&($_SESSION['id'] == $usuario->getAttribute('id_usuario'))){
        $donoPerfil = true;
    }

?>
    <div id="content">
        <input value="<?php if(isset($loggedUser)){echo $loggedUser->getAttribute('id_usuario');} ?>" id="id_usuario_logado" class="d-none">
        <section class="container-fluid" style="" id="profile-page">
            
            <div class="row">
                <div class="col-md-3" style="padding:20px;">
                    <div class="row d-print-none">
                        <div class="col-md-12 " style="padding:0; margin: 0 0 -5px;">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb" style="background-color:#fff;border-radius:0">
                                    <li class="breadcrumb-item"><a aria-label="inicio" href="home">Início</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?=$nomeSimpes; ?></li>
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
                                <img src="img/profile/<?=$usuario->getAttribute('des_foto'); ?>" alt="" id="usrFotoView">
                                <?php if($donoPerfil){ ?>
                                    <div id="fotoMouseOn" style="display:none">
                                        <img src="img/camera.png" alt="">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="infos">
                                <h5 class="text-center"><span class="profile-name"><?=$nomeSimpes;  ?></span> <span class="d-print-none" style="font-size:15px;font-weight:normal">-<i class="fa fa-star" style="margin-left:5px;font-size: 18px;color:rgb(255, 208, 0)"></i> 4,2</span></h5>
                                
                                


                                <div class="text-center">
                                    <p style="margin-top:-5px;font-size:14px;"><span id="sideOcupacao"><?=$usuario->getAttribute('des_ocupacao'); ?></span></p>
                                    <?php if(isset($_SESSION['id'])){
                                        if(!$donoPerfil){
                                            $ligacoes = $ligacao->loadById($loggedUser->getAttribute('id_usuario'),$usuario->getAttribute('id_usuario')); ?>
                                            <div style="margin-bottom:10px;">
                                                <button class="d-print-none btn btn-fc-<?php if(is_null($ligacoes) || count($ligacoes) == 0){echo 'primary';}else{echo 'danger';} ?>" id="criar-conexao" style="border-radius:5px;font-weight:400;height:34px;font-size:13px"<?php if(!isset($_SESSION['id'])||($_SESSION['id'] == $usuario->getAttribute('id_usuario'))){ echo 'disabled'; } ?>><i class="fas fa-user" style="margin-right:5px"></i> <span id="msg-btnContato"><?php if(is_null($ligacoes)  || count($ligacoes) == 0){echo ' Adicionar';}else{echo ' Remover';} ?></span> </button>
                                                <button class="btn btn-fc-primary d-print-none" style="border-radius:5px;font-weight:400;height:33px;font-size:13px"><i class="fas fa-comment" style="margin-right:2px"></i> Mensagem</button>
                                            </div>
                                        <?php } ?>
                                    <?php } else{ ?>      
                                        <div style="margin-bottom:10px;">
                                            <a href="identifique-se" class="d-print-none btn btn-fc-primary" style="border-radius:5px;font-weight:400;height:34px;font-size:13px"><i class="fas fa-user" style="margin-right:5px"></i> Adicionar</a>
                                            <a href="identifique-se" class="btn btn-fc-primary btn-radius d-print-none" style="border-radius:5px;font-weight:400; height:33px;font-size:13px"><i class="fas fa-comment" style="margin-right:2px"></i> Mensagem</a>
                                        </div>
                                    <?php } ?>
                                </div>
                                
                                <hr style="margin-left:-20px;margin-right:-20px">
                                <div class="list-infos">
                                    <div class="row">
                                        <p class="sub"><i class="fa fa-at"></i> <span><?php if($usuario != NULL){echo $usuario->getAttribute('des_slug');} ?></span></p>
                                        <p class="sub"><i class="fa fa-users"></i><span id="sideSexo">
                                            <?php if((!is_null($usuario->getAttribute('des_sexo')))&&($usuario->getAttribute('des_sexo') != '')){
                                                echo $usuario->getAttribute('des_sexo').', ';
                                            }
                                            $date = new DateTime( $usuario->getAttribute('dt_nasc') ); // data de nascimento
                                            $idade = Carbon::createFromDate($date->format( 'Y' ), $date->format( 'm' ), $date->format( 'd' ))->age;
                                           ?></span> <span id="sideIdade"><?=$idade.' anos'; ?></span>
                                        </p>
                                        <?php if(!is_null($usuario->getAttribute('id_cidade'))){ ?>
                                            <p class="sub"><i class="fa fa-map-marker" style="margin-left: 3px;margin-right: 8px;"></i><?=$usuario->getAttribute('id_cidade'); ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                        <hr class="d-print-none" style="margin-left:-20px;margin-right:-20px">
                            <div class="col-12 numbers-card d-print-none">
                                <div class="row text-center">
                                    <div class="col-4">
                                        <span style="font-size: 22px;font-weight:500;color:#3d4347">25</span>
                                        <p style="margin-top:-5px;margin-bottom:0;color:#777;font-weight:200">Concluídos</p>
                                    </div>
                                    <div class="col-4">
                                        <span style="font-size:22px;font-weight:500;color:#3d4347">20</span>
                                        <p style="margin-top:-5px;margin-bottom:0;color:#777;font-weight:200">Avaliações</p>
                                    </div>
                                    <div class="col-4">
                                        <button aria-label="Compartilhar perfil de <?=$nomeSimpes;?>" class="btn d-print-none btn-fc-primary btn-radius"  style="padding:0;margin-top:5px; height:40px; width:40px; margin-left:5px;" data-toggle="tooltip" data-placement="top" title="Compartilhar"><i class="fa fa-share"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="col-md-6">
                    <div class="row" style="margin-top:0">
                        <div class="col-md-12" id="visao-geral">
                            <div class="row">
                                <div class="col-md-12  profile-card">
                                    <ul class="nav nav-tabs d-print-none">
                                        <li class="nav-item ">
                                            <a aria-label="Visao geral" class="nav-link active" data-toggle="tab" href="#geral">Visão Geral</a>
                                        </li>
                                        <?php if(count($usuario->anuncios)>0 || (((isset($_SESSION['id']))&&($_SESSION['id']==$usuario->getAttribute('id_usuario'))))&& $loggedUser->getAttribute('des_status') == 'Ativo'){ ?>
                                            <li class="nav-item d-print-none">
                                                <a aria-label="Serviços" class="nav-link" data-toggle="tab" href="#servicos">Serviços</a>
                                            </li>
                                        <?php } ?>
                                        <?php if($donoPerfil && $loggedUser->getAttribute('des_status') == 'Ativo'){ ?>
                                            <a href="configuracoes" class="pull-right d-print-none" style="margin-top:7px;margin-left:20px">Configurações</a>
                                        <?php } ?>
                                    </ul>

                                    <div class="tab-content" style="padding-top:20px;">
                                        <div id="geral" class="tab-pane fade active show">
                                            <?php if ((!$donoPerfil)||($donoPerfil && $loggedUser->getAttribute('des_status') == 'Ativo')) { ?>

                                                <div class="clearfix">
                                                    <div class="col-12">
                                                        <p class="pull-left" style="width:auto;margin-top: 15px;margin-bottom:0;font-weight:400;font-size:18px;text-transform:uppercase"><i class="far fa-address-card" style="margin-left:-5px;font-size:20px;margin-right:10px"></i> Sobre</p>
                                                        <?php if($donoPerfil){ ?>
                                                            <div class="clearfix">
                                                                <button type="button" aria-label="Editar apresentação" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:13px;margin-bottom:-15px;" data-toggle="modal" data-target="#editApresentacaoModal"><i class="fa fa-edit" style="margin-right:5px;"></i>Editar</button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div id="apresentacao">
                                                    <div class="col-12">
                                                        <div style="margin-top:10px;margin-bottom:15px">
                                                            <div class="clearfix">
                                                                <input title="id usuario" style="position:absolute; display:none" id="id_usuario" value="<?=$usuario->getAttribute('id_usuario');?>">
                                                                <?php if(($usuario->getAttribute('des_apresentacao') != '')&&($usuario->getAttribute('des_apresentacao') != NULL)){ ?>
                                                                    <p id="des_apresentacao" style="margin-top:5px;margin-left:-7px;margin-right:-10px;font-weight:300"><?=$usuario->getAttribute('des_apresentacao');?></p>
                                                                <?php }else{ ?>
                                                                    <p id="des_apresentacao" style="margin-top:5px;margin-left:-7px;margin-right:-10px;font-weight:300">Olá, eu sou novo aqui. :)</p>
                                                                <?php } ?>
                                                            </div>
                                                            <hr style="margin-left:-5px;margin-right:-5px">
                                                        </div>
                                                    </div>
                                                </div>






                                                <?php if(($donoPerfil)||(count($usuario->experiencias)>0)){ ?>
                                                <div class="clearfix" style="margin-bottom:20px;">
                                                    <div class="col-12">
                                                        <p class="pull-left" style="width:auto;margin-top: 25px;margin-bottom:10px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-suitcase" style="margin-left:-5px;font-size:20px;margin-right:10px"></i> Experiências</p>
                                                        <?php if($donoPerfil){ ?>
                                                            <div class="clearfix">
                                                                <button type="button" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:28px;margin-bottom:-15px;" data-toggle="modal" data-target="#addExperienciaModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div id="experiencias-itens" style="margin-top:-15px;">

                                                    <?php foreach ($usuario->experiencias as $key => $value) { ?>
                                                        <div class="col-12">
                                                            <div class="clearfix">
                                                                <input type="text" class="id_experiencia d-none" value="<?=$usuario->experiencias[$key]->getAttribute('id_experiencia');?>">
                                                                <div class="row clearfix">
                                                                    <p class="des_titulo_experiencia col-11" style="width:auto; margin-left:-5px;font-weight:400; font-size:17px;margin-bottom:0px"><?=$usuario->experiencias[$key]->getAttribute('des_titulo');?></p>
                                                                    <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getAttribute('id_usuario')){ ?>
                                                                    <div class="btn-group col-1">
                                                                        <button type="button" class="btn btn-link dropdown-toggle d-print-none" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <button aria-label="Editar experiência" class="btn-editExperiencia dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                            <button aria-label="Deletar experiência" class="btn-delExperiencia text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                        </div>
                                                                    </div>
                                                                    <?php }} ?>
                                                                </div>
                                                                <p class="col-12 desc des_descricao_experiencia" style="margin-left:-10px;margin-right:-10px; padding-left:5px;font-weight:300;font-size:16px"><?=$usuario->experiencias[$key]->getAttribute('des_descricao');?></p>
                                                            </div>
                                                            <hr style="margin-left:-5px;margin-right:-5px">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>

                                                <?php if(($donoPerfil)||(count($usuario->formacoes)>0)){ ?>
                                                <div class="clearfix">
                                                    <div class="col-12">
                                                        <p class="pull-left" style="width:auto;margin-top: 30px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-trophy" style="margin-left:-5px;font-size:20px;margin-right:10px"></i> Formação</p>
                                                        <?php if($donoPerfil){ ?>
                                                            <div class="clearfix">
                                                                <button type="button" aria-label="Adicionar nova formação" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:28px;margin-bottom:-15px;" data-toggle="modal" data-target="#addFormacaoModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div id="formacoes-itens" class="row" style="margin-top:15px;margin-left:0px;padding-right:15px;">
                                                    <?php foreach ($usuario->formacoes as $key => $value) { ?>
                                                        <div class="col-12">
                                                            <div class="clearfix">
                                                                <input type="text" class="id_formacao" value="<?=$usuario->formacoes[$key]->getAttribute('id_formacao');?>" style="display:none">
                                                                <div class="row clearfix">
                                                                    <p class="des_titulo_formacao col-11" style="width:auto;margin-left:-5px;font-weight:400;font-size:17px;margin-bottom:0px;"><?=$usuario->formacoes[$key]->getAttribute('des_titulo');?></p>
                                                                    <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getAttribute('id_usuario')){ ?>
                                                                    <div class="btn-group col-1">
                                                                        <button type="button" class="btn btn-link dropdown-toggle d-print-none" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <button aria-label="Editar formação" class="btn-editFormacao dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                            <button aria-label="Deletar formação" class="btn-delFormacao text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                        </div>
                                                                    </div>
                                                                    <?php }} ?>
                                                                </div>
                                                                <p class="desc des_descricao_formacao" style="margin-left:-5px;margin-right:-10px;margin-top:0px;font-weight:300;color:#a0a5b5"><?=$usuario->formacoes[$key]->getAttribute('des_descricao');?></p>
                                                            </div>
                                                            <hr style="margin-left:-5px;margin-right:-5px">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>


                                                <?php if(($donoPerfil)||(count($usuario->habilidades)>0)){ ?>
                                                <div class="clearfix">
                                                    <div class="col-12">
                                                        <p class="pull-left" style="width:auto;margin-left:17px;margin-top: 30px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-lightbulb" style="margin-left:-20px;font-size:20px;margin-right:10px"></i> Habilidades</p>
                                                        <?php if($donoPerfil){ ?>
                                                            <div class="clearfix">
                                                                <button type="button" aria-label="Adicionar nova Habilidade" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:25px;margin-bottom:-15px;padding-left:10px;padding-right:10px" data-toggle="modal" data-target="#addHabilidadeModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div style="margin-top:0px">
                                                    <div id="habilidades-itens" class="row" style="margin-left:10px;margin-top:20px;margin-bottom:30px;">
                                                        <?php foreach ($usuario->habilidades as $key => $value) { ?>
                                                            <span id="<?=$usuario->habilidades[$key]->getAttribute('id_habilidade');?>" class="skills-label"><?=$usuario->habilidades[$key]->habilidade->getAttribute('des_descricao');?><?php if($donoPerfil){ ?><i class="fa fa-times-circle btn-delHabilidade d-print-none" style="margin-left:10px;cursor:pointer" aria-label="Deletar habilidade"></i><?php } ?></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <div class="alert alert-danger" role="alert">
                                                    Para utilizar todos os recursos da plataforma, por favor, <strong>confirme seu endereço de email</strong> através do link enviado.
                                                </div>
                                            <?php } ?>
                                        </div>

                                        
                                        <div id="servicos" class="tab-pane fade">
                                            <div class="clearfix">
                                                <p class="pull-left" style="width:auto;margin-left:12px;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;text-transform:uppercase"><i class="fa fa-globe" style="margin-left:-5px;font-size:20px;margin-right:10px"></i> Serviços</p>
                                                <?php if($donoPerfil){ ?>
                                                    <div class="pull-right">
                                                        <div class="clearfix">
                                                            <button type="button" aria-label="Adicionar novo serviço" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-bottom:-15px;margin-right:15px;margin-top:10px" data-toggle="modal" data-target="#addServicoModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                        </div>
                                                    </div>
                                                <?php } ?> 
                                            </div>
                                            
                                            
                                            <div id="servicos-itens" style="margin-top:35px">
                                                <?php foreach ($usuario->anuncios as $key => $value) { ?>
                                                    <div class="col-12 clearfix" style="margin-bottom:5px">
                                                        <input type="text" class="d-none id_servico" value="<?=$usuario->anuncios[$key]->getAttribute('id_anuncio');?>">
                                                        <div class="row clearfix">
                                                            <p class="des_categoria_servico col-11" id="<?=$usuario->anuncios[$key]->getAttribute('id_categoria');?>" style="width:auto; margin-left:-5px;font-weight:400; padding-right:25px;font-size:17px;margin-bottom:0px"><?=$usuario->anuncios[$key]->categoria['des_descricao'];?></p>
                                                            <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->getAttribute('id_usuario')){ ?>
                                                            <div class="btn-group col-1">
                                                                <button type="button" aria-label="Opções do serviço" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <button aria-label="Editar serviço" class="btn-editServico dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                    <button aria-label="Deletar serviço" class="btn-delServico text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                </div>
                                                            </div>
                                                            <?php }} ?>
                                                        </div>
                                                        
                                                        <p class="col-12 desc des_descricao_servico" style="margin-left:-10px;margin-right:-10px; padding-left:5px;padding-bottom:1px;padding-top:10px;font-weight:300;font-size:16px;"><?=$usuario->anuncios[$key]->getAttribute('des_descricao');?></p>
                                                        <p class="desc" style="margin-left:-5px">Preço: R$ <span class="des_preco_servico"><?= $usuario->anuncios[$key]->getAttribute('des_preco');?></span><span class="des_modalidade_servico" id="<?=$usuario->anuncios[$key]->getAttribute('id_modalidade');?>" style="margin-right:15px"> <?=$usuario->anuncios[$key]->modalidade['des_descricao'];?></span>
                                                        
                                                        Disponibilidade: <span class="des_disponibilidade_servico"><?=$usuario->anuncios[$key]->getAttribute('des_disponibilidade');?></span></p>
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
                    <?php $ligacoes = $ligacao->loadByUser($usuario->getAttribute('id_usuario'), 3); ?>
                    <div class="row d-print-none" style="margin-top: 15px;">
                        <div class="col-md-12">
                            <div class="col-12" style="padding:0px">
                                <div class="title-text-card clearfix">
                                    <h5 class="skills-title pull-left" style="font-weight:300;text-transform:uppercase">Contatos</h5>
                                </div>
                            </div>
                            <div class="col-12" style="padding:0px">
                                <div class="row">
                                    <?php if(count($ligacoes)>0){
                                    foreach ($ligacoes as $key => $value) { 
                                    $contato = $user->loadById($ligacoes[$key]->getAttribute('id_contato'));?>
                                        <div class="col-md-12" style="margin-top: 5px;margin-bottom: 10px;">
                                            <div class="row clearfix">
                                                <div class="col-2">
                                                    <a href="<?=$contato->getAttribute('des_slug');?>"><img src="img/profile/<?=$contato->getAttribute('des_foto');?>" alt="" class="rounded-circle" height="50"></a>
                                                </div>
                                                <div class="col-10" style="padding-left:30px;">
                                                    <a href="<?=$contato->getAttribute('des_slug');?>" class="nome-contato"><h6 style="font-weight:400;margin-bottom:3px;margin-top:3px"><?=explode( ' ',$contato->getAttribute('des_nome'))[0]. ' '.explode(' ', $contato->getAttribute('des_nome'))[count(explode( ' ', $contato->getAttribute('des_nome')))-1];?> -<i class="fa fa-star" style="margin-left:5px;font-size: 15px;color:rgb(255, 208, 0)"></i> 9,2</h6></a>
                                                    <span class="pull-left stars">
                                                        <a aria-label="<?=substr($contato->getAttribute('des_ocupacao'),0,100);?>" style="font-size:14px;color:#8b8b8b"><?=substr($contato->getAttribute('des_ocupacao'),0,100);?></a>
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
















<?php if((isset($_SESSION['id']))&&($_SESSION['id'] == $usuario->getAttribute('id_usuario'))){ ?>

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
                                <label>Habilidade:</label>
                                <select class="form-control" readonly name="des_habilidade_modal" id="des_habilidade_modal">
                                        <?php 
                                        $hab = new HabilidadeController();
                                        $hab = $hab->loadAll();
                                        foreach ($hab as $key => $value) { ?>
                                            <option value="<?=$hab[$key]->getAttribute('id_habilidade');?>"><?=$hab[$key]->getAttribute('des_descricao');?></option>
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
                                <label>Titulo:</label>
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
                                    <label>Titulo:</label>
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
            <?php $categorias = new CategoriaController();
                  $modalidades = new ModalidadeController(); ?>
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
                                        <option value="<?=$cat[$key]->getAttribute('id_categoria');?>"><?=$cat[$key]->getAttribute('des_descricao');?></option>
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
                                        <option value="<?=$cat[$key]->getAttribute('id_categoria');?>"><?=$mod[$key]->getAttribute('des_descricao');?></option>
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
<script src="js/profile.min.js"></script>
<script>
    $('.open-Login').click(function(e){
        e.stopPropagation();
        $('#dropdownMenu2').dropdown('toggle');
    });
</script>
</html>