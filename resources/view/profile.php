<?php
    use Controller\{HabilidadeController, CategoriaController, ModalidadeController};
    use Carbon\Carbon;

    include('template'.DS.'header.php');

?>
    <div id="content">
        <input value="<?=$logged_user->id_usuario ?? '';?>" id="id_usuario_logado" class="d-none">
        <section class="container-fluid" style="" id="profile-page">

            <div class="row">
                <div class="col-md-3" style="padding:20px;">

                    <div class="row">
                        <div class="col-md-12 profile-card text-center text-md-left">
                            <div class="img-profile" style="background: url('img/cover/cover.jpg');background-size: cover;">
                                <img src="img/profile/<?=$usuario->des_foto; ?>" alt="" id="usrFotoView" >
                                <?php if($dono_perfil){ ?>
                                    <form method="post" id="form-usrFoto" enctype="multipart/form-data" style="position:absolute">
                                        <input type="file" id="usrFoto" name="usrFoto" accept="image/jpeg" style="max-width:100%;display:none">
                                    </form>
                                    <div id="fotoMouseOn" style="display:none"  data-toggle="tooltip" data-placement="right" title="Atualizar foto do perfil">
                                        <img src="img/camera.png" alt="">
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="infos">
                                <h5 class="text-center"><span class="profile-name"><?=$usuario->des_nome_exibicao;  ?></span> <span class="d-print-none" style="font-size:15px;font-weight:normal">
                                <!-- -<i class="fa fa-star" style="margin-left:5px;font-size: 18px;color:rgb(255, 208, 0)"></i> 4,2 -->
                                </span></h5>
                                      

                                <div class="text-center">
                                    <p style="margin-top:-5px;font-size:14px;"><span id="sideOcupacao"><?=$usuario->des_ocupacao; ?></span></p>
                                    <?php if(isset($_SESSION['id'])){
                                        if(!$dono_perfil){
                                            $contato = $logged_user->ligacoes->where('id_contato', $usuario->id_usuario)->count(); ?>
                                            <div style="margin-bottom:10px;">
                                                <button class="d-print-none btn btn-fc-<?php if(!$contato){echo 'primary';}else{echo 'danger';} ?>" id="criar-conexao" style="border-radius:5px;font-weight:400;height:34px;font-size:13px"<?php if(!isset($_SESSION['id'])||($_SESSION['id'] == $usuario->id_usuario)){ echo 'disabled'; } ?>><i class="fas fa-user" style="margin-right:5px"></i> <span id="msg-btnContato"><?php if(!$contato){echo ' Adicionar';}else{echo ' Remover';} ?></span> </button>
                                                <a href="messages?to=<?=$usuario->id_usuario;?>" class="btn btn-fc-primary d-print-none" style="border-radius:5px;font-weight:400;height:33px;font-size:13px;color:#fff"><i class="fas fa-comment" style="margin-right:2px"></i> Mensagem</a>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <div style="margin-bottom:10px;">
                                            <a href="identifique-se" class="d-print-none btn btn-fc-primary" style="border-radius:5px;font-weight:400;height:34px;font-size:13px"><i class="fas fa-user" style="margin-right:5px"></i> Adicionar</a>
                                            <a href="identifique-se" class="btn btn-fc-primary btn-radius d-print-none" style="border-radius:5px;font-weight:400; height:33px;font-size:13px"><i class="fas fa-comment" style="margin-right:2px"></i> Mensagem</a>
                                        </div>
                                    <?php } ?>
                                </div>

                                <hr style="margin-left:-20px;margin-right:-20px">
                                <div class="list-infos" style="padding-left:10px;padding-right:10px">
                                    <div class="row">
                                        <p class="sub"><i class="fa fa-at"></i> <span><?=$usuario->des_slug ?? '';?></span></p>
                                        <p class="sub"><i class="fa fa-user"></i><span id="sideSexo">
                                            <?php 
                                            if((!is_null($usuario->des_sexo))&&($usuario->des_sexo != '')){
                                                if($usuario->des_sexo == 'M'){
                                                    echo 'Masculino'.', ';
                                                } else if($usuario->des_sexo == 'F'){
                                                    echo 'Feminino'.', ';
                                                }
                                            }
                                            $date = new DateTime( $usuario->dt_nasc ); // data de nascimento
                                            $idade = Carbon::createFromDate($date->format( 'Y' ), $date->format( 'm' ), $date->format( 'd' ))->age;
                                            ?></span> <span id="sideIdade"><?=$idade.' anos'; ?></span>
                                        </p>
                                        <p class="sub"><i class="fa fa-users"></i> <span><?=$usuario->ligacoes->count().' contatos';?></span></p>
                                        <?php if(!is_null($usuario->id_cidade)){ ?>
                                            <p class="sub"><i class="fa fa-map-marker" style="margin-left: 3px;margin-right: 8px;"></i> Mora em <strong><?=$usuario->cidade->des_nome;//.' - '.$usuario->cidade->estado->des_uf; ?></strong></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 numbers-card d-print-none" style="">
                                <hr class="d-print-none" style="margin-left:-10px;margin-right:-10px;">
                                <div class="row text-center" style="padding:0px 25px 20px 25px">
                                    <div class="col-4">
                                        <span style="font-size: 22px;font-weight:500;color:#3d4347">
                                        <?php
                                            $count = 0;
                                            foreach ($usuario->anuncios()->get() as $key => $anuncio) {
                                                $count += count($anuncio->avaliacoes()->get());
                                            }
                                            echo $count;
                                        ?></span>
                                        
                                        <p style="margin-top:-5px;margin-bottom:0;color:#777;font-weight:200">Avaliações</p>
                                    </div>
                                    <div class="col-4">
                                        <span style="font-size:22px;font-weight:500;color:#3d4347"><?=$usuario->des_nota?></span>
                                        <p style="margin-top:-5px;margin-bottom:0;color:#777;font-weight:200">Nota</p>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn d-print-none btn-fc-primary btn-radius"  style="padding:0;margin-top:5px; height:40px; width:40px; margin-left:5px;" data-toggle="tooltip" data-placement="top" title="Compartilhar"><i class="fa fa-share"></i></button>
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
                                <div class="col-md-12  profile-card" style="padding:20px;">
                                    <ul class="nav nav-tabs d-print-none">
                                        <li class="nav-item ">
                                            <a aria-label="Visao geral" class="nav-link active" data-toggle="tab" href="#geral">Visão Geral</a>
                                        </li>
                                        <?php if(count($usuario->anuncios)>0 || ($dono_perfil && $logged_user->des_status == 'Ativo')){ ?>
                                            <li class="nav-item d-print-none">
                                                <a aria-label="Serviços" class="nav-link" data-toggle="tab" href="#servicos">Serviços</a>
                                            </li>
                                        <?php } 
                                        if($dono_perfil && $logged_user->des_status == 'Ativo'){ ?>
                                            <a href="configuracoes" class="pull-right d-print-none" style="margin-top:7px;margin-left:20px">Configurações</a>
                                        <?php } ?>
                                    </ul>

                                    <div class="tab-content" style="padding-top:20px;">
                                        <div id="geral" class="tab-pane fade active show">
                                            <?php if ((!$dono_perfil)||($dono_perfil && $logged_user->des_status == 'Ativo')) { ?>

                                                <div class="clearfix">
                                                    <div class="col-12">
                                                        <h2 class="pull-left" style="width:auto;margin-top: 15px;margin-bottom:0;font-weight:400;font-size:18px;"><i class="far fa-address-card" style="margin-left:-5px;font-size:20px;margin-right:10px"></i> Sobre</h2>
                                                        <?php if($dono_perfil){ ?>
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
                                                                <input title="id usuario" style="position:absolute; display:none" id="id_usuario" value="<?=$usuario->id_usuario;?>">
                                                                <?php if(($usuario->des_apresentacao != '')&&($usuario->des_apresentacao != NULL)){ ?>
                                                                    <p id="des_apresentacao" style="margin-top:5px;margin-left:-7px;margin-right:-10px;font-weight:300"><?=$usuario->des_apresentacao;?></p>
                                                                <?php }else{ ?>
                                                                    <p id="des_apresentacao" style="margin-top:5px;margin-left:-7px;margin-right:-10px;font-weight:300">Olá, eu sou novo aqui. :)</p>
                                                                <?php } ?>
                                                            </div>
                                                            <!-- <hr style="margin-left:-5px;margin-right:-5px"> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr style="background-color: #ccc; margin-left:-20px;margin-right:-20px; margin-top: 30px">






                                                <?php if(($dono_perfil)||(count($usuario->experiencias)>0)){ ?>
                                                <div class="clearfix" style="margin-bottom:20px;">
                                                    <div class="col-12">
                                                        <p class="pull-left" style="width:auto;margin-top: 25px;margin-bottom:10px;font-weight:400;font-size:18px;"><i class="fa fa-suitcase" style="margin-left:-5px;font-size:20px;margin-right:10px"></i> Experiência</p>
                                                        <?php if($dono_perfil){ ?>
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
                                                                <input type="text" class="id_experiencia d-none" value="<?=$usuario->experiencias[$key]->id_experiencia;?>">
                                                                <div class="row clearfix">
                                                                    <p class="des_titulo_experiencia col-11" style="width:auto; margin-left:-5px;font-weight:400; font-size:17px;margin-bottom:0px"><?=$usuario->experiencias[$key]->des_titulo;?></p>
                                                                    <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->id_usuario){ ?>
                                                                    <div class="btn-group col-1">
                                                                        <button type="button" class="btn btn-link dropdown-toggle d-print-none" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <button aria-label="Editar experiência" class="btn-editExperiencia dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                            <button aria-label="Deletar experiência" class="btn-delExperiencia text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                        </div>
                                                                    </div>
                                                                    <?php }} ?>
                                                                </div>
                                                                <?php 
                                                                    // $date_de = new DateTime( $usuario->experiencias[$key]->des_de );
                                                                    // $date_ate = new DateTime( $usuario->experiencias[$key]->des_ate );
                                                                    // $des_ate = $usuario->experiencias[$key]->des_ate ? strftime('%b de %Y', strtotime($usuario->experiencias[$key]->des_ate)) : 'o momento';
                                                                ?>
                                                                <!-- <p class="desc des_de" style="margin-left:-10px;margin-right:-10px; padding-left:5px;font-weight:300;font-size:15px;margin-top:5px">//=strftime('%b de %Y', strtotime($usuario->experiencias[$key]->des_de));?> – =$des_ate;?></p> -->
                                                                <p class="col-12 desc des_descricao_experiencia" style="margin-left:-10px;margin-right:-10px; padding-left:5px;font-weight:300;font-size:16px; margin-top: -5px;"><?=$usuario->experiencias[$key]->des_descricao;?></p>
                                                            </div>
                                                            <hr style="margin-left:-5px;margin-right:-5px">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>

                                                <?php if(($dono_perfil)||(count($usuario->formacoes)>0)){ ?>
                                                <div class="clearfix">
                                                    <div class="col-12">
                                                        <p class="pull-left" style="width:auto;margin-top: 30px;margin-bottom:0px;font-weight:400;font-size:18px;"><i class="fa fa-trophy" style="margin-left:-5px;font-size:20px;margin-right:10px"></i> Formação</p>
                                                        <?php if($dono_perfil){ ?>
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
                                                                <input type="text" class="id_formacao" value="<?=$usuario->formacoes[$key]->id_formacao;?>" style="display:none">
                                                                <div class="row clearfix">
                                                                    <p class="des_titulo_formacao col-11" style="width:auto;margin-left:-5px;font-weight:400;font-size:17px;margin-bottom:0px;"><?=$usuario->formacoes[$key]->des_titulo;?></p>
                                                                    <?php if(isset($_SESSION['id'])){if($_SESSION['id'] == $usuario->id_usuario){ ?>
                                                                    <div class="btn-group col-1">
                                                                        <button type="button" class="btn btn-link dropdown-toggle d-print-none" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <button aria-label="Editar formação" class="btn-editFormacao dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                            <button aria-label="Deletar formação" class="btn-delFormacao text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                        </div>
                                                                    </div>
                                                                    <?php }} ?>
                                                                </div>
                                                                <p class="desc des_descricao_formacao" style="margin-left:-5px;margin-right:-10px;margin-top:0px;font-weight:300;color:#a0a5b5"><?=$usuario->formacoes[$key]->des_descricao;?></p>
                                                            </div>
                                                            <hr style="margin-left:-5px;margin-right:-5px">
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <?php } ?>


                                                <?php if(($dono_perfil)||(count($usuario->habilidades)>0)){ ?>
                                                <div class="clearfix">
                                                    <div class="col-12">
                                                        <p class="pull-left" style="width:auto;margin-left:17px;margin-top: 30px;margin-bottom:0px;font-weight:400;font-size:18px;"><i class="fa fa-lightbulb" style="margin-left:-20px;font-size:20px;margin-right:10px"></i> Habilidades</p>
                                                        <?php if($dono_perfil){ ?>
                                                            <div class="clearfix">
                                                                <button type="button" aria-label="Adicionar nova Habilidade" class="btn btn-fc-primary btn-radius pull-right btn-sm d-print-none" style="margin-top:25px;margin-bottom:-15px;padding-left:10px;padding-right:10px" data-toggle="modal" data-target="#addHabilidadeModal"><i class="fa fa-plus-circle" style="margin-right:5px;"></i>Adicionar</button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div style="margin-top:0px">
                                                    <div id="habilidades-itens" class="row" style="margin-left:10px;margin-top:20px;margin-bottom:30px;">
                                                        <?php foreach ($usuario->habilidades as $key => $value) { ?>
                                                            <span id="<?=$usuario->habilidades[$key]->id_habilidade;?>" class="skills-label"><?=$usuario->habilidades[$key]->habilidade->des_descricao;?><?php if($dono_perfil){ ?><i class="fa fa-times-circle btn-delHabilidade d-print-none" style="margin-left:10px;cursor:pointer" aria-label="Deletar habilidade"></i><?php } ?></span>
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
                                                <p class="pull-left" style="width:auto;margin-left:12px;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;"><i class="fa fa-globe" style="margin-left:-5px;font-size:20px;margin-right:10px"></i> Serviços</p>
                                                <?php if($dono_perfil){ ?>
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
                                                        <input type="text" class="d-none id_servico" value="<?=$usuario->anuncios[$key]->id_anuncio;?>">
                                                        <div class="row clearfix">
                                                            <p class="des_categoria_servico col-11" id="<?=$usuario->anuncios[$key]->id_categoria;?>" style="width:auto; margin-left:-5px;font-weight:400; padding-right:25px;font-size:17px;margin-bottom:0px"><a href="servico/<?=$usuario->anuncios[$key]->id_anuncio;?>"><?=$usuario->anuncios[$key]->categoria['des_descricao'];?></a></p>
                                                            <?php if($dono_perfil){ ?>
                                                            <div class="btn-group col-1">
                                                                <button type="button" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <button aria-label="Editar serviço" class="btn-editServico dropdown-item" type="button" style="cursor:pointer">Editar</button>
                                                                    <button aria-label="Deletar serviço" class="btn-delServico text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>

                                                        <p class="col-12 desc des_descricao_servico" style="margin-left:-10px;margin-right:-10px; padding-left:5px;padding-bottom:1px;padding-top:10px;font-weight:300;font-size:16px;"><?=$usuario->anuncios[$key]->des_descricao;?></p>
                                                        <p class="desc" style="margin-left:-5px">Preço: R$ <span class="des_preco_servico"><?= $usuario->anuncios[$key]->des_preco;?></span><span class="des_modalidade_servico" id="<?=$usuario->anuncios[$key]->id_modalidade;?>" style="margin-right:15px"> <?=$usuario->anuncios[$key]->modalidade['des_descricao'];?></span>

                                                        Disponibilidade: <span class="des_disponibilidade_servico"><?=$usuario->anuncios[$key]->des_disponibilidade;?></span></p>
                                                        <hr style="margin-left:-5px;margin-right:-5px">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="padding:20px;">
                    <div class="row d-print-none" style="margin-top: 15px;">
                        <div class="col-md-12">
                            <div class="col-12" style="padding:0px">
                                <div class="title-text-card clearfix">
                                    <h5 class="skills-title pull-left" style="font-weight:300;text-transform:uppercase">Contatos</h5>
                                </div>
                            </div>
                            <div class="col-12" style="padding:0px">
                                <div class="row">
                                <?php $ligacoes = $usuario->ligacoes->take(3);
                                    if(count($ligacoes) == 0){ ?>
                                        <div class="col-md-12" style="margin-top: 5px;margin-bottom: 10px;color:#8b8b8b">
                                            Nenhum Contato
                                        </div>
                                    <?php } else {
                                        foreach ($ligacoes as $key => $ligacao) { ?>
                                            <div class="col-md-12" style="margin-top: 5px;margin-bottom: 10px;">
                                                <div class="row clearfix">
                                                    <div class="col-2">
                                                        <a href="<?=$ligacao->contato->des_slug;?>"><img src="img/profile/<?=$ligacao->contato->des_foto;?>" alt="" class="rounded-circle" height="50"></a>
                                                    </div>
                                                    <div class="col-10" style="padding-left:30px;">
                                                        <a href="<?=$ligacao->contato->des_slug;?>" class="nome-contato"><h6 style="font-weight:400;margin-bottom:3px;margin-top:3px"><?=$ligacao->contato->des_nome_exibicao;?> -<i class="fa fa-star" style="margin-left:5px;font-size: 15px;color:rgb(255, 208, 0)"></i> <?=$ligacao->contato->des_nota;?></h6></a>
                                                        <span class="pull-left stars">
                                                            <a aria-label="<?=substr($ligacao->contato->des_ocupacao, 0, 100);?>" style="font-size:14px;color:#8b8b8b"><?=substr($ligacao->contato->des_ocupacao,0,100);?></a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
















<?php if($dono_perfil){ ?>

    <!-- Modal Editar Apresentacao -->
    <div class="modal fade" id="editApresentacaoModal" tabindex="-1" role="dialog" aria-label="editApresentacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apresentação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12" style="margin-top:10px">
                                <label for="des_email">Resumo:</label>
                                <textarea class="form-control" name="des_apresentacao_modal" id="des_apresentacao_modal" cols="30" rows="8" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-editApresentacao" class="btn btn-sm btn-fc-primary col-2">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Habilidade -->
    <div class="modal fade" id="addHabilidadeModal" tabindex="-1" role="dialog" aria-label="addHabilidadeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document" style="">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Habilidades</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label>Habilidade:</label>
                                <select class="form-control selectpicker" data-live-search="true" readonly name="des_habilidade_modal" id="des_habilidade_modal">
                                        <?php
                                            $hab = new HabilidadeController();
                                            $hab = $hab->loadAll();
                                            foreach ($hab as $key => $value) { ?>
                                                <option value="<?=$hab[$key]->id_habilidade;?>"><?=$hab[$key]->des_descricao;?></option>
                                            <?php } ?>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" aria-label="Salvar habilidade" id="btn-addHabilidade" class="btn btn-sm btn-fc-primary col-2">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Adicionar Experiência -->
    <div class="modal fade" id="addExperienciaModal" tabindex="-1" role="dialog" aria-label="addExperienciaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Experiência</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12" style="display:none">
                                <input type="text" name="id_experiencia_modal" id="id_experiencia_modal" value="">
                            </div>
                            <div class="col-12">
                                <label>Titulo:</label>
                                <input class="form-control" type="text" name="des_titulo_experiencia" id="des_titulo_experiencia" placeholder="">
                            </div>
                            <!-- <div class="col-6" style="margin-top:10px">
                                <label>De:</label>
                                <input class="form-control" type="date" name="des_de" id="des_de" placeholder="">
                            </div>
                            <div class="col-6" style="margin-top:10px">
                                <label>Até:</label>
                                <input class="form-control" type="date" name="des_ate" id="des_ate" placeholder="">
                            </div> -->
                            <div class="col-12" style="margin-top:10px">
                                <label for="des_email">Descrição:</label>
                                <textarea class="form-control" name="des_descricao_experiencia" id="des_descricao_experiencia" cols="30" rows="6" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" aria-label="Salvar experiência" id="btn-addExperiencia" class="btn btn-sm btn-fc-primary col-2">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Formação -->
    <div class="modal fade" id="addFormacaoModal" tabindex="-1" role="dialog" aria-label="addFormacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width:400px;">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Formação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                    <div class="modal-body">
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
                                    <textarea class="form-control" name="des_descricao_formacao" id="des_descricao_formacao" cols="30" rows="5" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" aria-label="Salvar formação" id="btn-addFormacao" class="btn btn-sm btn-fc-primary col-2">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar Serviço -->
    <div class="modal fade" id="addServicoModal" tabindex="-1" role="dialog" aria-label="addServicoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Serviço</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php $categorias = new CategoriaController();
                  $modalidades = new ModalidadeController(); ?>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                            <div class="row">
                                <div class="col-12" style="display:none">
                                    <input type="text" name="id_servico_modal" id="id_servico_modal" value="">
                                </div>
                                <!-- <div class="col-12" style="margin-top:10px">
                                    <label for="des_email">Imagem:</label>
                                    <input class="form-control" type="file" name="des_foto_servico" id="des_foto_servico" placeholder="">
                                </div> -->
                                <div class="col-12">
                                    <label for="">Categoria:</label>
                                    <select class="form-control" readonly name="des_categoria_servico" id="des_categoria_servico">
                                        <?php
                                            $cat = $categorias->loadAll();
                                            foreach ($cat as $key => $value) { ?>
                                            <option value="<?=$cat[$key]->id_categoria;?>"><?=$cat[$key]->des_descricao;?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12" style="margin-top:10px">
                                    <label for="des_email">Descrição:</label>
                                    <textarea class="form-control" name="des_descricao_servico" id="des_descricao_servico" cols="30" rows="5" style="height:auto;resize: none;" spellcheck="false" placeholder=""></textarea>
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
                                            <option value="<?=$cat[$key]->id_categoria;?>"><?=$mod[$key]->des_descricao;?></option>
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
                        <button type="button" id="btn-addServico" class="btn btn-sm btn-fc-primary col-2">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('template'.DS.'footer.php'); ?>
<script src="js/profile.js"></script>
<script>
    $('.open-Login').click(function(e){
        e.stopPropagation();
        $('#dropdownMenu2').dropdown('toggle');
    });
</script>
</html>
