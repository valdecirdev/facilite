<?php 
    require_once('config.php');

    $search = new Busca();
    $usuarios = new Usuario();
    $modalidades = new Modalidade();
    $categorias = new Categoria();

    $pg_title = '';
    include_once('_includes/header.php');
?>

    <header>
        <div class="home-header container-fluid opacity-dark">
            <div class="row">
                <div class="col-lg-8 pull-left">
                    <h2>Facilite Serviços</h2>
                    <br>
                    <h5>Ótimos serviços com preços justos e total transparência.</h5>
                    <br>
                    <p>Encontre prestadores de serviços e conecte-se a novos clientes em poucos cliques.</p>
                    <br>
                    <button type="button" class="btn btn-header btn-fc-primary btn-radius">SAIBA MAIS</button>
                </div>
                <?php if(!isset($_SESSION['nome'])){ ?>
                <div class="col-md-4 pull-right d-none d-lg-block login-box">
                    <h4>Entrar</h4>
                    <p style="margin-top:0px">O Facilite ajuda você a encontrar o melhor serviço pelo melhor preço.</p>
                    <div id="login-alert" class="d-none col-12" style="padding:0px;margin-bottom:-5px;margin-top:5px;">
                        <strong style="color:red;font-size:13px;">Email e/ou senha incorreto!</strong>
                    </div>
                    <form action="" method="POST">
                        <input type="text" name="login_des_email" id="login_des_email" placeholder="email@exemplo.com ">
                        <input type="password" name="des_senha" id="login_des_senha" placeholder="Senha">
                        <button type="button" id="login-user" class="btn btn-fc-primary col-12 btn-radius">Conectar</button>
                    </form>
                    <div class="modal-bottom-divider" style="margin-bottom:5px;" ></div>
                    <a data-toggle="modal" style="cursor:pointer" data-target="#registerModal">Ainda não tem uma conta? <span style="color:#0074b7">Cadastrar-se</span></a>
                </div> <?php } ?>
            </div>
        </div>
    </header>
    <div class="title-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3>Encontre o que você precisa!</h3>
                </div>
            </div>
        </div>
    </div>
    <section class="cards container">
        <div class="row">
            <?php 
            if(isset($_SESSION['id'])){
                $anuncios = $search->search("",$_SESSION['id']);
            }else{
                $anuncios = $search->search("","*");
            }
            foreach ($anuncios as $key => $value) {
                $usuario = $usuarios->loadById($anuncios[$key]->getIdUsuarioAnuncio()); 
                $modalidade = $modalidades->loadById($anuncios[$key]->getIdModalidadeAnuncio()); 
                $categoria = $categorias->loadbyId($anuncios[$key]->getIdCategoriaAnuncio()); ?>
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                    <div class="card card-body">
                        <div class="row" style="height:75">
                            <div class="col-2">
                                <a href="#">
                                    <i class="<?php echo $categoria->getIconeCategoria(); ?> icon-align-center" aria-hidden="true"></i>
                                </a>
                            </div>
                            <div class="col-10">
                                <a href="">
                                    <h4 class="job-title font-weight-bold">
                                        <?php echo $categoria->getDescricaoCategoria(); ?>
                                    </h4>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 numbers-card">
                                <div class="row text-center">
                                    <div style="width: 30%">
                                        <span style="font-size: 22px;font-weight:bold;">25</span>
                                        <p style="margin-top: -5px">Concluídos</p>
                                    </div>
                                    <div style="width: 40%">
                                        <span style="font-size: 13px">R$</span>
                                        <span style="font-size:22px;font-weight:bold;"><?php echo $anuncios[$key]->getPrecoAnuncio(); ?></span>
                                        <p style="margin-top: -5px"><?php echo $modalidade->getDescricaoModalidade(); ?></p>
                                    </div>
                                    <div style="width: 30%">
                                        <span style="font-size:22px;font-weight:bold;">20</span>
                                        <p style="margin-top: -5px">Avaliações</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 desc-card">
                                <p style="min-height:70px; margin-bottom:0px;"><?php echo $anuncios[$key]->getDescricaoAnuncio(); ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12"><hr></div>
                            <div class="col-2">
                                <img src="view/_img/profile/<?php echo $usuario->getFotoUsuario(); ?>" alt="" class="profile-face-footer rounded-circle">
                            </div>
                            <div class="col-10 footer-card">
                                <a href="<?php echo $usuario->getSlugUsuario(); ?>" class="username"><h5><?php echo $usuario->getNomeSimplesUsuario(); ?></h5></a>
                                <span class="float-left stars" style="margin-top: -3px;">
                                    <a><i class="fa fa-star" style="font-size: 18px"></i> 4,2</a>
                                </span>
                                <span class="float-right">
                                    <a href="#" style="margin-right:-10px !important"> <i class="fa fa-user-plus grey-text ml-3"></i></a>
                                    <a href="#"><i class="fa fa-share-alt grey-text ml-3"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

        <!--Footer-->
<?php include_once('_includes/footer.php'); ?>