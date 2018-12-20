<?php

    use Controller\{BuscaController, UsuarioController, ModalidadeController, CategoriaController};
    
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
    include('template'.DIRECTORY_SEPARATOR.'header.php');
    
?>
    <div id="content">
        <section id="profile-page" class="container-fluid">
            

            <div class="row" style="margin-top:20px;">
                <div class="col-md-3" style="padding-left:20px;padding-right:20px;margin-bottom:20px;">
                    
                    


                    <div class="row">
                        <div class="profile-card col-md-12 clearfix">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-12" style="margin-top:0px; padding: 35px">
                                        <!-- <div style="margin-bottom:15px"> -->
                                            
                                        <!-- </div> -->
                    <!-- <a class="" data-toggle="collapse" href="#filtrosSearch" role="button" aria-expanded="false" aria-controls="filtrosSearch" class="text-secondary font-weight-bold" style="font-size:14px">Filtros Avançados</a> -->
                    <div id="filtrosSearch"> <!-- class="collapse multi-collapse" -->
                        <div style="margin-top:-5px;">
                                                
                            <div class="row">
                                <form action="" method="get">
                                    <div class="col-12">
                                        <div class="form-group text-secondary">
                                            <label for="organizar">Pesquisa</label>
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="q" value="<?=$_GET['q'] ?? '';?>" style="border-radius:0px">
                                            </div>
                                            <div class=" text-right">
                                                <span style="font-size:12px;">
                                                    <?php
                                                    $cat = $_GET['cat'] ?? NULL;
                                                    $min_price = $_GET['min_price'] ?? 0;
                                                    $max_price = $_GET['max_price'] ?? NULL;
                                                    
                                                   
                                                    
                                                    
                                                    $total_results = $search->searchCount($_GET['q'], $_SESSION['id'] ?? '*', $cat, $min_price, $max_price);
                                                    echo '('.$total_results.' resultados)'; ?> 
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                            <div class="form-group text-secondary">
                                                <label for="organizar">Organizar</label>
                                                <div class="form-group">
                                                    <?php $ord_search = $_GET['ord'] ?? ''; ?>
                                                    <select class="form-control" name="ord" id="organizar" style="border-radius:0px">
                                                        <option value="recent">Mais recentes</option>
                                                        <option <?php if($ord_search == 'lowest'){echo("selected");}?> value="lowest">Menor Preço</option>
                                                        <option <?php if($ord_search == 'biggest'){echo("selected");}?> value="biggest">Maior Preço</option>
                                                    </select>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="col-12" style="margin-top:5px;">
                                        <div class="form-group text-secondary">
                                            <label for="exampleFormControlSelect1">Categorias</label>
                                            <div class="form-group">
                                                <select class="form-control" name="cat" id="categoria" style="border-radius:0px">
                                                <option value=""></option>
                                                <?php
                                                    $cat_search = $_GET['cat'] ?? '';
                                                    $cat = $categorias->loadAll();
                                                    foreach ($cat as $key => $categoria) { ?>
                                                        <option <?php if($cat_search == $categoria->des_descricao){echo("selected");}?>><?=$categoria->des_descricao;?></option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="col-12" style="margin-top:5px;">
                                            <div class="form-group text-secondary">
                                                <label>Preço</label>
                                                <div class="form-group">
                                                    <div class="row" style="margin-top: 0px;">
                                                        <div class="col-6">
                                                            <?php
                                                                $min_price = $_GET['min_price'] ?? '';
                                                                if(is_numeric($min_price)){
                                                                    $min_price = number_format($min_price, 2, '.', '');
                                                                }
                                                            ?>
                                                            <input type="number" class="form-control" name="min_price" placeholder="Mínimo" style="border-radius:0px" value="<?=$min_price;?>">
                                                        </div>
                                                        <div class="col-6">
                                                            <?php
                                                                $max_price = $_GET['max_price'] ?? '';
                                                                if(is_numeric($max_price)){
                                                                    $max_price = number_format($max_price, 2, '.', '');
                                                                }
                                                            ?>
                                                            <input type="number" class="form-control" name="max_price" placeholder="Máximo" style="border-radius:0px" value="<?=$max_price;?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="col-12" style="margin-top:5px;">
                                                <button type="submit" class="btn btn-fc-primary col-12">Filtrar</button>
                                            </div>
                                        </form>
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
                                        $ord = $_GET['ord'] ?? NULL;
                                        $cat = $_GET['cat'] ?? NULL;
                                        $min_price = $_GET['min_price'] ?? 0;
                                        $max_price = $_GET['max_price'] ?? NULL;
                                        
                                        $anuncios = $search->search($_GET['q'], $_SESSION['id'] ?? '*',$min,$max, $ord, $cat, $min_price, $max_price);
                                        
                                    foreach ($anuncios as $key => $value) { 
                                        $usuario = $anuncios[$key]->usuario;?>
                                        <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                            <div class="card card-body">
                                                <div class="row" style="min-height:0px;">
                                                    <div class="col-2">
                                                        <a href="servico/<?=$anuncios[$key]->id_anuncio;?>">
                                                            <div class="">
                                                                <i class="<?php echo $anuncios[$key]->categoria['des_icone']; ?> icon-align-center" aria-hidden="true"></i>
                                                            </div>
                                                    </a>
                                                </div>
                                                    <div class="col-10 title-card">
                                                        <a href="servico/<?=$anuncios[$key]->id_anuncio;?>"><h4 class="job-title font-weight-bold">
                                                                <?php echo $anuncios[$key]->categoria['des_descricao']; ?>
                                                        </h4></a>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 numbers-card">
                                                        <div class="row text-center">
                                                            <div style="width: 30%">
                                                                <span style="font-size: 22px;font-weight:500;"><?=count($anuncios[$key]->avaliacoes)?></span>
                                                                <p style="margin-top: -5px">Concluídos</p>
                                                            </div>
                                                            <div style="width: 40%">
                                                                <span style="font-size: 13px">R$</span>
                                                                <span style="font-size: 22px;font-weight:500;"><?php echo $anuncios[$key]->getAttribute('des_preco'); ?></span>
                                                                <p style="margin-top: -5px"><?php echo $anuncios[$key]->modalidade['des_descricao']; ?></p>
                                                            </div>
                                                            <div style="width: 30%">
                                                                <span style="font-size: 22px;font-weight:500;"><?=count($anuncios[$key]->avaliacoes)?></span>
                                                                <p style="margin-top: -5px">Avaliações</p>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 desc-card">
                                                        <p style="min-height:70px; margin-bottom:0px;"><?php echo substr($anuncios[$key]->getAttribute('des_descricao'), 0, 95);  if (strlen($anuncios[$key]->getAttribute('des_descricao')) > 120) {echo "...";} ?></p>
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
                                                        <a href="<?php echo $usuario->getAttribute('des_slug'); ?>" class="username"><h6 style="font-weight:400"><?=$usuario->getAttribute('des_nome_exibicao'); ?></h6></a>
                                                        <span class="float-left stars" style="margin-top: -5px;">
                                                            <a style="font-size: 15px"><i class="fa fa-star"></i> <?=$usuario->getAttribute('des_nota');?></a>
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
                                                    <?php
                                                        $j = $i+1;
                                                        $uri = $_SERVER["REQUEST_URI"];
                                                        if(isset($_GET['pg'])){
                                                            $uri = str_replace('&pg='.$_GET['pg'], "&pg=$j", $uri);
                                                        }else {
                                                            $uri.="&pg=$j";
                                                        }
                                                    ?>
                                                    <li class="page-item <?php if($pg == $i+1){echo 'active';} ?>"><a class="page-link" href="<?php echo $uri ?>"><?php echo $i+1; ?></a></li>
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


<?php include('template'.DS.'footer.php'); ?>