
<?php if(!isset($_SESSION['id'])){ ?>
    <!-- Modal Cadastro -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="padding:10px 10px 0px 10px">
                <div class="pull-left clearfix" style="padding:10px;" tabindex="1">
                    <button type="button btn-lg" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST">
                <div class="modal-body">
                    <h4 style="margin-top:-30px;">Abra uma conta</h4>
                    <p>Encontre o melhor serviço pelo melhor preço!</p>

                        <div class="row">
                            <div class="col-12">
                                <label for="des_nome">Nome Completo:</label>
                                <input class="form-control" type="text" name="des_nome" id="des_nome" placeholder="">
                            </div>
                            <div class="col-6">
                                <label for="des_email">Email:</label>
                                <input class="form-control" type="email" name="des_email" id="des_email" placeholder="">
                            </div>
                            <div class="col-6">
                                <label for="des_senha">Senha:</label>
                                <input class="form-control" type="password" name="des_senha" id="des_senha" placeholder="">
                            </div>
                            <div class="col-6">
                                <label for="des_sexo">Sexo:</label>
                                <select class="form-control" name="des_sexo" id="des_sexo">
                                    <option value="F">Feminino</option>
                                    <option value="M">Masculino</option>
                                    <option value="P">Prefiro não informar </option>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="dt_nasc">Data de Nascimento:</label>
                                <input class="form-control" type="date" name="dt_nasc" id="dt_nasc">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="register-user" class="btn btn-success col-12">Cadastre-se</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
<?php } ?>

<footer class="page-footer text-white d-print-none">
    <div class="text-center container text-md-left">
        <div class="row">
            <div class="col-md-8 col-lg-8">
                <p class="text-center text-md-left grey-text">© 2018 Copyright - Facilite Servicos</p>
            </div>

            <div class="col-md-4 col-lg-4 ml-lg-0 text-center text-md-right" style="padding-bottom:10px;">
                <a class="fb-ic ml-0"><i class="fa fa-facebook white-text mr-lg-4"> </i></a>
                <a class="tw-ic"><i class="fa fa-twitter white-text mr-lg-4"> </i></a>
                <a class="ins-ic"><i class="fa fa-instagram white-text mr-lg-4"> </i></a>
            </div>
        </div>
    </div>
</footer>

<script src="view/_js/jquery-3.1.1.min.js"></script>
<script src="view/_js/popper.min.js"></script>
<script src="view/_js/bootstrap.min.js"></script>
<script src="view/_js/app.js"></script>
</body>