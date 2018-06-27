<?php
    require_once('../autoload.php');
    $pg_title = "Identifique-se - ";
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

    <section id="app" style="color:#5b5855;width:400px;margin-top:120px;margin-bottom:100px;min-height:50px;margin-left:auto;margin-right:auto;background-color:#fff;padding:40px;border-radius:3px"/>
        <h4 class="text-center"/>faça login na Facilite Serviços</h4>
        
        <p class="text-center" style="margin-top:30px">O Facilite ajuda você a encontrar o melhor serviço pelo melhor preço.</p>
        <div id="login-alert" class="d-none alert alert-danger alert-dismissible fade show" role="alert">
            Email e/ou senha incorreta!
        </div>
        <form @submit="checkForm" action="" method="post" style="margin-top:30px">
            <div class="form-group">
                <label for="login_des_email">email</label>
                <input type="email" class="form-control" id="login_des_email" name="login_des_email" v-model="email" placeholder="">
            </div>
            <div class="form-group">
                <label for="login_des_senha">senha</label>
                <input type="password" class="form-control" id="login_des_senha" name="des_senha" v-model="senha" placeholder="">
            </div>
            <div class="clearfix text-center" style="margin-bottom: -15px;margin-top:20px">
                <button type="submit" aria-label="Fazer Login" id="loginuser" class="btn btn-fc-primary btn-radius" style="padding-left:35px;padding-right:35px">entrar</button>
            </div>
            <p class="text-center" style="margin-top:30px"><sub>Ainda não tem uma conta?</sub></p>
            <div class="clearfix text-center" style="margin-bottom: -15px;margin-top:20px">
                <a href="cadastre-se" aria-label="Cadastrar-se" id="" style="padding-left:35px;padding-right:35px">Crie sua conta</a>
            </div>
            
        </form>
    </section>
        
    


<?php
    include_once('_includes'.DIRECTORY_SEPARATOR.'footer.php');
?>
<script src="view/_js/login_vue.js"></script>
</body>
<html>