<?php
    require_once('config.php');
    
    $search = new Busca();
    $usuarios = new Usuario();
    $modalidades = new Modalidade();
    $categorias = new Categoria();
    
    if((!isset($_GET['q']))||($_GET['q'] == NULL)){
        $pg_title = "Pesquisa - ";
    }else{
        $pg_title = $_GET['q'].' - ';
    }
    include_once('_includes'.DIRECTORY_SEPARATOR.'header.php');
    
    
?>

    <section id="profile-page" class="container-fluid">
        <div class="row d-print-none">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home">Início</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pesquisa: <?php echo $_GET['q']; ?></li>
                </ol>
            </nav>
        </div>
        <div class="row" style="margin-top:-10px;">
            <div class="col-md-3" style="padding-left:30px;padding-right:30px;">
                <div class="row">
                    <div id="" class="profile-card col-md-12 card clearfix">
                        <div class="tab-content">
                            <div class="col-12" style="margin-bottom:20px">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-secondary" style="font-size:17px;">
                                        <?php if(isset($_SESSION['id'])){ echo count($search->search($_GET['q'],$_SESSION['id']));}else{echo count($search->search($_GET['q'],"*"));} ?> Resultados
                                        </div>
                                        <div class="pull-right align-middle" style="margin-top:-22px;">
                                            <a href="">
                                                <i class="fa fa-repeat text-secondary" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12" style="margin-top:10px;">
                                        <a class="" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2" class="text-secondary font-weight-bold">Opções Avançadas</a>
                                        <div class="collapse multi-collapse" id="multiCollapseExample2">
                                            <div style="margin-top:10px;">
                                                
                                            <div class="row">
                                    <div class="col-12" style="margin-top:25px;">
                                        <form action="">
                                        <div class="form-group text-secondary">
                                        <label for="exampleFormControlSelect1" class="font-weight-bold">Ordenar</label>
                                            <div class="form-group">
                                                <select class="form-control" id="exampleFormControlSelect1">
                                                    <option>Mais Relevantes</option>
                                                    <option>Menor Preço</option>
                                                    <option>Maior Preço</option>
                                                </select>
                                            </div>
                                        </div>
                                        </form>
                                    </div>

                                    <div class="col-12" style="margin-top:25px;">
                                        <!-- <form action=""> -->
                                        <div class="form-group text-secondary">
                                        <label for="exampleFormControlSelect1" class="font-weight-bold">Categorias</label>
                                            <div class="form-group">
                                            <?php 
                                            $cat = $categorias->loadAll();
                                            foreach ($cat as $key => $value) { ?> 
                                                <a href=""><?php echo $cat[$key]->getDescricaoCategoria(); ?></a> 
                                            <?php } ?>
                                            </div>
                                        </div>
                                        <!-- </form> -->
                                    </div>

                                    <div class="col-12" style="margin-top:25px;">
                                        <!-- <form action=""> -->
                                        <div class="form-group text-secondary">
                                        <label for="exampleFormControlSelect1" class="font-weight-bold">Localização</label>
                                            <div class="form-group">
                                            
                                            </div>
                                        </div>
                                        <!-- </form> -->
                                    </div>

                                    <div class="col-12" style="margin-top:25px;">
                                        <!-- <form action=""> -->
                                        <div class="form-group text-secondary">
                                        <label for="exampleFormControlSelect1" class="font-weight-bold">Nivel</label>
                                            <div class="form-group">
                                            
                                            </div>
                                        </div>
                                        <!-- </form> -->
                                    </div>

                                    <div class="col-12" style="margin-top:25px;">
                                        <!-- <form action=""> -->
                                        <div class="form-group text-secondary">
                                        <label for="exampleFormControlSelect1" class="font-weight-bold">Preço</label>
                                            <div class="form-group">
                                            
                                            </div>
                                        </div>
                                        <!-- </form> -->
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
            <div class="col-md-9" style="">
                <div class="row">
                    <div id="" class="col-md-12">                            
                        <div class="tab-content">
                            <div class="row">


                                <?php if(isset($_SESSION['id'])){
                                        $anuncios = $search->search($_GET['q'],$_SESSION['id']);
                                    }else{
                                        $anuncios = $search->search($_GET['q'],"*");
                                    }
                                   foreach ($anuncios as $key => $value) { 
                                       $usuario = $usuarios->loadById($anuncios[$key]->getIdUsuarioAnuncio()); 
                                       $modalidade = $modalidades->loadById($anuncios[$key]->getIdModalidadeAnuncio()); 
                                       $categoria = $categorias->loadbyId($anuncios[$key]->getIdCategoriaAnuncio()); ?>
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="card card-body">
                                                <div class="row" style="min-height:88px;">
                                                    <div class="col-2">
                                                        <a href="#">
                                                            <div class="">
                                                                <i class="<?php echo $categoria->getIconeCategoria(); ?> icon-align-center" aria-hidden="true"></i>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="col-10 title-card">
                                                        <a href=""><h4 class="job-title font-weight-bold">
                                                                <?php echo $categoria->getDescricaoCategoria(); ?>
                                                        </h4></a>
                                                        <?php
                                                            $date = strtotime($usuario->getDtCadastroUsuario());
                                                            $date = date('d/m/Y',$date);
                                                        ?>
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
                                                        <span class="float-left stars">
                                                            <a><i class="fa fa-star" style="font-size: 18px"></i> 9,2</a>
                                                        </span>
                                                        <span class="float-right">
                                                            <a href="#" class="icon-bag"> <i class="fa fa-shopping-bag grey-text ml-3"></i></a>
                                                            <a href="#" class="icon-share"><i class="fa fa-share-alt grey-text ml-3"></i></a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   <?php } ?>
                                



                                
                                
                                
                               
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text">
                                <nav aria-label="Page navigation example">
                                    <?php $cont = count($anuncios)/10;
                                    if($cont > 0){ ?>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item"><a class="page-link" href="#"><</a></li>
                                            <?php for($i=0;$i <= $cont;$i++){ ?>
                                                <li class="page-item <?php if($_GET['pg'] == $i){echo 'active';} ?>"><a class="page-link" href="#?pg=<?php echo $i ?>"><?php echo $i+1; ?></a></li>
                                            <?php } ?>
                                            <li class="page-item"><a class="page-link" href="#">></a></li>
                                        </ul>
                                    <?php } ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </section>


    

<?php include_once('_includes'.DS.'footer.php'); ?>