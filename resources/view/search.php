<?php

    use controller\{BuscaController, UsuarioController, ModalidadeController, CategoriaController};
    
    $search = new BuscaController();
    $usuarios = new UsuarioController();
    $modalidades = new ModalidadeController();
    $categorias = new CategoriaController();
    
    if((!isset($_GET['q']))||($_GET['q'] == NULL)){
        $pg_title = "Pesquisa - ";
        $_GET['q'] = '';
    }else{
        $pg_title = $_GET['q'].' - ';
    }
    include('_includes'.DIRECTORY_SEPARATOR.'header.php');
    
    
?>
    <div id="content">
        <section id="profile-page" class="container-fluid">
            

            <div class="row" style="margin-top:20px;">
                <div class="col-md-3" style="padding-left:20px;padding-right:20px;margin-bottom:20px;">
                    
                    


                    <div class="row">
                        <div class="profile-card col-md-12 clearfix">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-12" style="margin-top:0px;">
                                        <div style="margin-bottom:15px">
                                            Pesquisa: <?php echo '"'.strip_tags($_GET['q']).'"'; ?>
                                            <span style="font-size:12px;">
                                                <?php if(isset($_SESSION['id'])){
                                                    $total_results = $search->searchCount($_GET['q'],$_SESSION['id']);
                                                }else{
                                                    $total_results = $search->searchCount($_GET['q'],"*");
                                                }
                                                echo '</br>('.$total_results.' resultados)'; ?> 
                                            </span></br>
                                        </div>
                                        <a class="" data-toggle="collapse" href="#filtrosSearch" role="button" aria-expanded="false" aria-controls="filtrosSearch" class="text-secondary font-weight-bold" style="font-size:14px">Filtros Avançados</a>
                                        <div class="collapse multi-collapse" id="filtrosSearch">
                                            <div style="margin-top:10px;">
                                                
                                            <div class="row">
                                    <div class="col-12">
                                        <form action="">
                                            <div class="form-group text-secondary">
                                                <label for="organizar">Organizar</label>
                                                <div class="form-group">
                                                    <select class="form-control" id="organizar" style="border-radius:0px">
                                                        <option>Mais recentes</option>
                                                        <option>Menor Preço</option>
                                                        <option>Maior Preço</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-12" style="margin-top:5px;">
                                        <div class="form-group text-secondary">
                                            <label for="exampleFormControlSelect1">Categorias</label>
                                            <div class="form-group">
                                                <?php
                                                $cat = $categorias->loadAll();
                                                foreach ($cat as $key => $value) { ?>
                                                    <a href=""><?php echo $cat[$key]->getAttribute('des_descricao'); ?></a><br>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-12" style="margin-top:5px;">
                                            <div class="form-group text-secondary">
                                                <label>Preço</label>
                                                <div class="form-group">
                                                    <div class="row" style="margin-top: 0px;">
                                                        <div class="col-6">
                                                            <input type="number" class="form-control" placeholder="Mínimo" style="border-radius:0px">
                                                        </div>
                                                        <div class="col-6" style="margin-left:-20px">
                                                            <input type="number" class="form-control" placeholder="Máximo" style="border-radius:0px">
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
                        </div>
                    </div>
                    <div class="col-md-7"><!-- style="padding:5px;padding-top:0px">-->
                        <div class="row">
                            <div id="" class="col-md-12">                            
                                <div class="tab-content">
                                    <div class="row">
    

                                    <?php 
                                        if((isset($_GET['pg']))&&($_GET['pg'] > 1)){
                                            $pg = $_GET['pg'];
                                            $min = (($pg-1)*10);
                                            $max = $pg*10;
                                        }else{
                                            $pg = 1;
                                            $min = 0;
                                            $max = 10;
                                        }
                                        if(isset($_SESSION['id'])){
                                            $anuncios = $search->search($_GET['q'],$_SESSION['id'],$min,$max);
                                        }else{
                                            $anuncios = $search->search($_GET['q'],"*",$min,$max);
                                        }
                                    foreach ($anuncios as $key => $value) { 
                                        $usuario = $usuarios->loadById($anuncios[$key]->getAttribute('id_usuario')); ?>
                                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                                <div class="card card-body">
                                                    <div class="row" style="min-height:0px;">
                                                        <div class="col-2">
                                                            <a href="#">
                                                                <div class="">
                                                                    <i class="<?php echo $anuncios[$key]->categoria['des_icone']; ?> icon-align-center" aria-hidden="true"></i>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <div class="col-10 title-card">
                                                            <a href=""><h4 class="job-title font-weight-bold">
                                                                    <?php echo $anuncios[$key]->categoria['des_descricao']; ?>
                                                            </h4></a>
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
                                                                    <span style="font-size: 22px;font-weight:500;"><?php echo $anuncios[$key]->getAttribute('des_preco'); ?></span>
                                                                    <p style="margin-top: -5px"><?php echo $anuncios[$key]->modalidade['des_descricao']; ?></p>
                                                                </div>
                                                                <div style="width: 30%">
                                                                    <span style="font-size: 22px;font-weight:500;">20</span>
                                                                    <p style="margin-top: -5px">Avaliações</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 desc-card">
                                                            <p style="min-height:70px; margin-bottom:0px;"><?php echo substr($anuncios[$key]->getAttribute('des_descricao'), 0, 120);  if (strlen($anuncios[$key]->getAttribute('des_descricao')) > 120) {echo "...";} ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12"><hr></div>
                                                        <div class="col-2">
                                                            <a href="<?php echo $usuario->getAttribute('des_slug'); ?>">
                                                                <img src="img/profile/<?php echo $usuario->getAttribute('des_foto'); ?>" alt="" height="55px" width="55px" class="profile-face-footer rounded-circle">
                                                            </a>
                                                        </div>
                                                        <div class="col-10 footer-card">
                                                            <?php $nome = explode(' ', $usuario->getAttribute('des_nome')); ?>
                                                            <a href="<?php echo $usuario->getAttribute('des_slug'); ?>" class="username"><h6 style="font-weight:400"><?php echo $nome[0] .' '. $nome[count($nome)-1]; ?></h6></a>
                                                            <span class="float-left stars" style="margin-top: -5px;">
                                                                <a style="font-size: 15px"><i class="fa fa-star"></i> 4,2</a>
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
                                        <?php $cont = $total_results/10;
                                        if($cont > 0){ ?>
                                            <ul class="pagination justify-content-center">
                                                <li class="page-item"><a class="page-link" href="#"><</a></li>
                                                <?php for($i=0;$i <= $cont;$i++){  ?>
                                                    <li class="page-item <?php if($pg == $i+1){echo 'active';} ?>"><a class="page-link" href="?q=<?php echo $_GET['q']; ?>&pg=<?php echo $i+1 ?>"><?php echo $i+1; ?></a></li>
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
    </div>


<?php include('_includes'.DS.'footer.php'); ?>