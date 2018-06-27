<?php
    require_once('../autoload.php');
    $pg_title = "Cadastre-se - ";
    include_once('_includes'.DIRECTORY_SEPARATOR.'header.php'); 
?>
    <script>
        var logado = <?php if(isset($_SESSION['id'])){echo !is_null($_SESSION['id']);}else{echo 0;} ?>;
        if(logado){
            window.location.href="home";
        }
    </script>

    <style>
        input{
            height: 45px;
            border-radius: 3px !important;
        }
    </style>
    <section id="app" class="col-md-6" style="margin-top:120px;margin-bottom:100px;min-height:50px;margin-left:auto;margin-right:auto;background-color:#fff;padding:40px;border-radius:3px">
        <h4 class="text-center">abra uma conta</h4>
        <p class="text-center" style="margin-top:30px">crie sua conta e aproveite tudo! </br>já tem conta? <a href="identifique-se">faça login</a>.</p>
        <div id="register-alert" class="d-none alert alert-danger alert-dismissible fade show" role="alert">
            Erro ao criar cadastro, verifique as informações.
        </div>
        <form @submit="checkForm" action="" method="POST" style="margin-top:30px" class="row">
            <div class="form-group col-md-12">
                <label for="des_nome">nome completo</label>
                <input type="text" class="form-control" id="des_nome" name="des_nome" v-model="nome" placeholder="">
            </div>
            <div class="form-group col-md-6">
                <label for="des_email">email</label>
                <input type="email" class="form-control" id="des_email" name="des_email" v-model="email" placeholder="">
            </div>
            <div class="form-group col-md-6">
                <label for="des_senha">senha</label>
                <input type="password" class="form-control" id="des_senha" name="des_senha" v-model="senha" placeholder="">
            </div>
            <div class="form-group col-md-6">
                <label for="des_sexo">sexo:</label>
                <select class="form-control" name="des_sexo" v-model="sexo" id="des_sexo" style="height: 45px;">
                    <option value="F">Feminino</option>
                    <option value="M">Masculino</option>
                    <option value="P">Prefiro não informar </option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="dt_nasc">data de nascimento</label>
                <input type="date" class="form-control" id="dt_nasc" name="dt_nasc" v-model="dt_nasc" placeholder="">
            </div>
            <div class="form-group col-md-12">
                <button type="submit" id="register-user" class="btn btn-success col-12" style="margin-top:10px">cadastre-se</button>
                <p class="text-center" style="margin-top:10px"><sub>ao clicar em criar conta, você está de acordo com os <a href="">termos de serviço</a> da Facilite Serviços.</sub></p>
            </div>
        </form>
    </section>



<?php
    include_once('_includes'.DIRECTORY_SEPARATOR.'footer.php');
?>
<script src="view/_js/register_vue.js"></script>
</body>
<html>