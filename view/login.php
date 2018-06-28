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
        html, body{
            background-color:#f4f4ef;
        }
        input{
            height: 45px;
            border-radius: 3px !important;
        }
        .auth-box{
            color:#5b5855;
            margin-top:100px;
            margin-bottom:100px;
            min-height:50px;
            margin-left:auto;
            margin-right:auto;
            background-color:#fff;
            padding:0px;
            border: 1px #dbe2e8 solid;
        }
        .head-menu{
            list-style:none;
            margin:0px;
            padding:0px;
        }
        .head-menu li{
            float: left;
            background-color:#fafbfc;
            margin:0px;
            padding-top: 15px;
            padding-bottom: 15px;
            width:50%;
            text-align:center;
            text-transform: uppercase;
            border-bottom: 1px #dbe2e8 solid;
            margin-bottom:30px
        }
        .head-menu li{
            color: #7d97b6;
            font-size:16px;
            font-weight:500;
        }
        .head-menu .active{
            background-color:#fff;
            border-bottom: 1px transparent solid;
            color: #000;
        }
    </style>

    <section id="app" class="auth-box col-md-5">
        <ul class="head-menu">
            <a href="cadastre-se"><li>Registrar-se</li></a>
            <li class="active" style="border-left: 1px #dbe2e8 solid;">Entrar</li>
        </ul>
        <div style="padding:40px; color: #2e3d49">
            <h2 style="font-weight:300">Entrar em sua conta</h2>
            
            <p style="margin-top:20px">Sua conta é a porta de entrada para um mundo de oportunidades na Facilite Serviços!</p>
            <div id="login-alert" class="d-none alert alert-danger alert-dismissible fade show" role="alert">
                Email e/ou senha incorreta!
            </div>
            <form @submit="checkForm" action="" method="post" style="margin-top:30px">
                <div class="form-group">
                    <!-- <label for="login_des_email">email</label> -->
                    <input type="email" class="form-control" id="login_des_email" name="login_des_email" v-model="email" placeholder="Endereço de Email">
                </div>
                <div class="form-group">
                    <!-- <label for="login_des_senha">senha</label> -->
                    <input type="password" class="form-control" id="login_des_senha" name="des_senha" v-model="senha" placeholder="Senha">
                </div>
                <p style="margin-top:30px">Ao clicar em 'Entrar', você concorda com nossos <a href="">Termos de Uso</a> e nossa <a href="">Política de Privacidade</a>.</p>
                <div class="clearfix text-center" style="margin-bottom: -15px;margin-top:20px">
                    <button type="submit" aria-label="Fazer Login" id="loginuser" class="btn btn-primary col-12" style="margin-top:10px;padding-top:15px;padding-bottom:15px;background-color:#02b3e4;border-color:#02b3e4">ENTRAR</button>
                </div>
               
                
            </form>
        </div>
    </section>
        
    


<?php
    include_once('_includes'.DIRECTORY_SEPARATOR.'footer.php');
?>
<script src="view/_js/login_vue.js"></script>
</body>
<html>