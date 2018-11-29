<?php
    

    include('template'.DS.'header.php');

?>
    <div id="content">
        <input value="<?=$logged_user->id_usuario ?? '';?>" id="id_usuario_logado" class="d-none">
        <section class="container-fluid" style="" id="profile-page">

            <div class="row">
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 profile-card" id="visao-geral" style="padding: 40px; margin-top:20px">
                            <div class="row">
                                <div class="offset-3 col-6">
                                    <h3><i class="<?=$servico->categoria->des_icone;?>" style="margin-right:15px;color:rgb(255, 208, 0)"></i> <?=$servico->categoria->des_descricao;?></h3>
                                    <p style="margin-top:25px"><?=$servico->des_descricao;?></p>
                                    <p><strong>Disponibilidade:</strong> <?=$servico->des_disponibilidade;?></p>
                                    <p class="col-12 text-center" style="margin-top:35px;">
                                        R$ <span style="font-size:2rem;font-weight: 500"><?=$servico->des_preco?></span>
                                        <span style="text-transform: lowercase"><?=' / '.$servico->modalidade->des_descricao;?></span>
                                    </p>
                                    <p class="col-12 text-center" style="margin-top:25px">
                                        <?php  if(isset($logged_user)){ ?>
                                            <a href="/messages?to=<?=$usuario->id_usuario;?>" class="btn btn-lg btn-fc-primary">Enviar Mensagem</a>
                                        <?php } else { ?>
                                            <a href="/identifique-se" class="btn btn-lg btn-fc-primary">Enviar Mensagem</a>
                                        <?php } ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" style="padding-top:35px">
                                    <hr>
                                    <!-- TODO: This is for server side, there is another version for browser defaults -->
                                    <form action="" method="post">
                                        <input type="text" id="id_usuario" value="<?=$logged_user->id_usuario ?? '';?>" style="display:none">
                                        <input type="text" id="id_anuncio" value="<?=$servico->id_anuncio ?? '';?>" style="display:none">
                                        <div class="form-group">
                                          <label for="">Deixe um Comentário:</label>
                                          <textarea class="form-control" name="" id="des_comentario" rows="3" style="border-radius:0px"></textarea>
                                        </div>
                                        <div class="form-group">
                                          <label for="">Nota:</label>
                                          <input type="number" class="form-control col-2" name="" id="des_nota" placeholder="" style="border-radius:0px">
                                          <small id="helpId" class="form-text text-muted">Dê uma nota de 0 a 5</small>
                                        </div>
                                        <?php  if(isset($logged_user)){ ?>
                                            <button type="button" id="btn-avaliar" class="btn btn-fc-primary col-2">Enviar</button>
                                        <?php } else { ?>
                                            <a href="/identifique-se" class="btn btn-fc-primary col-2">Enviar</a>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" style="padding-top:35px">
                                    <?php 
                                        if(!is_null($servico->avaliacoes)){
                                            $avaliacoes = $servico->avaliacoes->get();
                                    ?>
                                    <hr>
                                    <h5 style="font-weight: 400; margin-bottom: 25px">Avaliações:</h5>
                                    <div id="list-avaliacoes">
                                        <?php
                                            foreach ($avaliacoes as $key => $avaliacao) {
                                                if($avaliacao->id_anuncio == $servico->id_anuncio){
                                        ?>
                                            <div class="row" style="margin-top: 15px">
                                                <div class="col-1">
                                                    <a href="/<?=$avaliacao->usuario->des_slug;?>"><img src="../img/profile/<?=$avaliacao->usuario->des_foto;?>" alt="" class="rounded-circle" height="50"></a>
                                                </div>
                                                <div class="col-10">
                                                    <p><i class="fa fa-star" style="font-size: 15px;color:rgb(255, 208, 0)"></i> <?=$avaliacao->des_nota;?>
                                                    - <?=$avaliacao->des_comentario;?></p>
                                                    <p style="margin-top:-10px"><a href="/<?=$avaliacao->usuario->des_slug;?>"><?=$avaliacao->usuario->des_nome_exibicao;?></a></p>
                                                </div>
                                            </div>
                                        <?php } } ?>    
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="padding:20px;">
                    <div class="row d-print-none" style="margin-top: 15px;">
                        <div class="col-md-12">
                            <div class="col-12" style="padding:0px">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 5px;margin-bottom: 10px;">
                                        <div class="row clearfix">
                                            <div class="col-2">
                                                <a href="/<?=$usuario->des_slug;?>"><img src="../img/profile/<?=$usuario->des_foto;?>" alt="" class="rounded-circle" height="50"></a>
                                            </div>
                                            <div class="col-10" style="padding-left:30px;">
                                                <a href="/<?=$usuario->des_slug;?>" class="nome-contato"><h6 style="font-weight:400;margin-bottom:3px;margin-top:3px"><?=$usuario->des_nome_exibicao;?> -<i class="fa fa-star" style="margin-left:5px;font-size: 15px;color:rgb(255, 208, 0)"></i> 4,2</h6></a>
                                                <span class="pull-left stars">
                                                    <a style="font-size:14px;color:#8b8b8b"><?=substr($usuario->des_ocupacao,0,100);?></a>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row clearfix">
                                            <div class="col-12">
                                                <p style="font-size:14px;color:#8a8a8a; margin-top: 15px"><?=substr($usuario->des_apresentacao, 0, 150).'...';?></p>
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>



<?php include('template'.DS.'footer.php'); ?>
<script src="../js/service.js"></script>
</html>
