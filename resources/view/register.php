<?php
    require('../../bootstrap/app.php');
    $pg_title = "Cadastre-se - ";
    include('_includes'.DIRECTORY_SEPARATOR.'header.php'); 
?>
    <script>
        var logado = <?php if(isset($_SESSION['id'])){echo !is_null($_SESSION['id']);}else{echo 0;} ?>;
        if(logado){
            window.location.href="home";
        }
    </script>
    <section id="app" class="auth-box col-md-5">
        <ul class="head-menu">
            <li class="active">Registrar-se</li>
            <a href="identifique-se"><li style="border-left: 1px #dbe2e8 solid;">Entrar</li></a>
        </ul>
        <div style="padding:40px; color: #2e3d49">
            <h2 style="font-weight:300">Crie sua conta</h2>
            <p style="margin-top:20px">Sua conta é a porta de entrada para um mundo de oportunidades na Facilite Serviços!</p>
            <div id="register-alert" class="d-none alert alert-danger alert-dismissible fade show" role="alert">
                Erro ao criar cadastro, verifique as informações.
            </div>
            <form @submit="checkForm" action="" method="POST" style="margin-top:30px" class="row">
                <div class="form-group col-md-12">
                    <!-- <label for="des_nome">nome completo</label> -->
                    <input type="text" class="form-control" id="des_nome" name="des_nome" v-model="nome" placeholder="Nome Completo">
                </div>
                <div class="form-group col-md-6">
                    <!-- <label for="des_email">email</label> -->
                    <input type="email" class="form-control" id="des_email" name="des_email" v-model="email" placeholder="Endereço de Email">
                </div>
                <div class="form-group col-md-6">
                    <!-- <label for="des_senha">senha</label> -->
                    <input type="password" class="form-control" id="des_senha" name="des_senha" v-model="senha" placeholder="Senha">
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
                <p style="margin-top:10px">Ao clicar em 'Registrar-se', você concorda com nossos <a href="">Termos de Uso</a> e nossa <a href="">Política de Privacidade</a>.</p>
                    <button type="submit" aria-label="Cadastrar-se" class="btn btn-primary col-12" style="margin-top:10px;padding-top:15px;padding-bottom:15px;background-color:#02b3e4;border-color:#02b3e4">REGISTRAR-SE</button>
                </div>
            </form>
        </div>
    </section>



<?php
    include('_includes'.DIRECTORY_SEPARATOR.'footer.php');
?>
<script src="app/view/_js/register_vue.js"></script>
</body>
<html>

    