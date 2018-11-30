<?php

    use Controller\{BuscaController, UsuarioController, CategoriaController};

    $search = new BuscaController();
    $usuarios = new UsuarioController();

    include('template/header.php');
?>

    <div id="content">
        <header>
            <div class="home-header container-fluid opacity-dark">
                <div class="row">
                    <div class="col-lg-8 pull-left">
                        <h2>Facilite Serviços</h2><br>
                        <h5>Ótimos serviços com preços justos e total transparência.</h5><br>
                        <p>Encontre prestadores de serviços e conecte-se a novos clientes em poucos cliques.</p><br>
                        <button type="button" class="btn btn-header btn-fc-primary" style="border-radius:0">SAIBA MAIS</button>
                    </div>
                </div>
            </div>
        </header>
        <nav id="nav-categorias" class="navbar navbar-expand-md navbar-dark" style="z-index:999">
            <div class="container">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCategorias" aria-controls="navbarCategorias" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCategorias">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Categorias
                            </a>
                            <div class="dropdown-menu dropdown-categorias" aria-labelledby="navbarDropdown">
                                <?php
                                    $categorias = new CategoriaController();
                                    $categorias = $categorias->loadLimit(10);
                                    foreach ($categorias as $key => $categoria) { ?>
                                        <a class="dropdown-item" href="/search?cat=<?=$categoria->des_descricao?>"><?=$categoria->des_descricao?></a>
                                    <?php } ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/search">Ver todas</a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/search">Destaques da Semana</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/search">Contratar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/<?=$logged_user->slug ?? 'identifique-se';?>">Anúnciar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>



        <section class="container" style="padding-top:20px;margin-bottom:-30px">
            <div class="row">
                <div class="col-12">
                    <h2 style="color:#666a6e;font-weight:300;">Encontre o que você precisa! <a href="search" style="margin-left:5px;font-size:18px">ver mais</a></h2>
                </div>
            </div>
        </section>
        <section class="cards container">
            <div class="row">
                <?php
                $anuncios = $search->search('', $_SESSION['id'] ?? '*', 0, 12, NULL);
                foreach ($anuncios as $key => $anuncio) { ?>
                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                        <div class="card card-body">
                            <div class="row" style="height:45px">
                                <div class="col-2">
                                    <a href="servico/<?=$anuncio->id_anuncio;?>">
                                        <i class="<?=$anuncio->categoria->des_icone;?> icon-align-center" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="col-10">
                                    <a href="servico/<?=$anuncio->id_anuncio;?>">
                                        <h4 class="job-title font-weight-bold">
                                            <?=$anuncio->categoria->des_descricao;?>
                                        </h4>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 numbers-card">
                                    <div class="row text-center">
                                        <div style="width: 30%">
                                            <span style="font-size: 22px;font-weight:500;">25</span>
                                            <p style="margin-top: -5px">Concluídos</p>
                                        </div>
                                        <div style="width: 40%">
                                            <span style="font-size: 13px">R$</span>
                                            <span style="font-size:22px;font-weight:500;"><?=$anuncio->des_preco;?></span>
                                            <p style="margin-top: -5px"><?=$anuncio->modalidade->des_descricao;?></p>
                                        </div>
                                        <div style="width: 30%">
                                            <span style="font-size:22px;font-weight:500;">20</span>
                                            <p style="margin-top: -5px">Avaliações</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 desc-card">
                                    <p style="min-height:70px; margin-bottom:0px;"><?php echo substr($anuncio->des_descricao, 0, 120);  if (strlen($anuncio->des_descricao) > 120) {echo "...";} ?></p>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:-10px">
                                <div class="col-12"><hr></div>
                                <div class="col-2">
                                    <a href="<?=$anuncio->usuario->des_slug;?>">
                                        <img src="img/profile/<?=$anuncio->usuario->des_foto; ?>" alt="" height="55px" width="55px" class="rounded-circle">
                                    </a>
                                </div>
                                <div class="col-10 footer-card">
                                    <a href="<?=$anuncio->usuario->des_slug; ?>" class="username"><h6 style="font-weight:400"><?=$anuncio->usuario->des_nome_exibicao; ?></h6></a>
                                    <span class="float-left stars" style="margin-top: -5px;">
                                        <a style="font-size: 15px"><i class="fa fa-star"></i> <?=$anuncio->usuario->des_nota?></a>
                                    </span>
                                    <span class="float-right">
                                        <a href="<?php if(isset($logged_user)){ echo '/#'; } else { echo '/cadastre-se';}?>" style="margin-right:-10px !important"> <i class="fa fa-user-plus grey-text ml-3" style="color: #e6366b"></i></a>
                                        <a href="#"><i class="fa fa-share-alt ml-3" style="color: #e6366b"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="row" style="padding:15px">
                <a href="search" class="col-12 btn btn-fc-primary" style="padding-top:15px;padding-bottom:15px;text-transform:uppercase;border-radius:0">Mais opções...</a>
            </div>
        </section>
    </div>
        <!--Footer-->
    <?php include('template/footer.php'); ?>
