<?php

    use controller\Usuario;

    require('../bootstrap/bootstrap.php');
    
    $pg_title = 'Configurações - ';
    include('_includes'.DS.'header.php');
    if(!isset($_SESSION['id'])){
        header('location: home');
    }

    ?><script>usuario = <?php echo $loggedUser; ?>;</script>
    
    <style>
        input{
            height: 45px;
            border-radius: 0px !important;
        }    
    </style>
    <div id="content">
        <input type="text" value="<?php if(isset($loggedUser)){echo $loggedUser->getIdUsuario();} ?>" id="id_usuario_logado" class="d-none">
        <section class="container-fluid" style="" id="profile-page">
            
            <div class="row">
                <div class="col-md-3" style="padding:20px;">
                    <div class="row d-print-none">
                        <div class="col-md-12 " style="padding:0px;margin:0px;margin-bottom:-5px">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb" style="background-color:#fff;border-radius:0px">
                                    <li class="breadcrumb-item"><a aria-label="inicio" href="home">Início</a></li>
                                    <li class="breadcrumb-item active">Configurações</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 profile-card text-center text-md-left">
                            <ul class="nav nav-tabs-confgs">
                                <li class="nav-item ">
                                    <a class="nav-link active" data-toggle="tab" href="#basicos">Informações Básicas</a>
                                </li>
                                <li class="nav-item d-print-none">
                                    <a class="nav-link" data-toggle="tab" href="#pessoal">Informações Pessoais</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#senha">Alterar Senha</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                




                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12" id="visao-geral">
                            <div class="row">
                                <div class="col-md-12 profile-card">
                                    <div class="tab-content" style="margin-top:-10px;">
                                        <div id="basicos" class="tab-pane fade active show" style="padding-left:15px">
                                            <div class="row"> 
                                                <div class="col-12">
                                                    <p class="pull-left" style="width:auto;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;">Informações básicas</p>
                                                </div>
                                            </div>
                                            <div class="row" style="margin-top:20px">
                                                <div class="col-md-8">
                                                    
                                                    <p class="basic-msg d-none"></p>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-12 row" style="padding-left:20px">
                                                            <label for="slugUsr" class="col-12" style="margin-left:-15px">Nome de usuario</label>
                                                            <div class="input-group col-md-9" style="padding:0px">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="inputGroupPrepend2" style="border-radius:0px">faciliteserv.com/</span>
                                                                </div>
                                                                <input type="text" class="form-control block-plaintext" id="slugUsr" v-model="user.slug_usuario">
                                                            </div>
                                                            <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarUsuario()" style="border-radius:0px">Salvar</button>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-row">
                                                        <div class="form-group col-md-12 row" style="padding-left:20px">
                                                            <label for="nomeUsr" class="col-12" style="margin-left:-15px">Nome completo</label>
                                                            <input type="text" class="form-control col-md-9" id="nomeUsr" v-model="user.nome_usuario" placeholder="Nome Completo:">
                                                            <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarNome()" style="border-radius:0px">Salvar</button>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-12 row" style="padding-left:20px">
                                                            <label for="emailUsr" class="col-12" style="margin-left:-15px">Email</label>
                                                            <input type="text" class="form-control col-md-9" id="emailUsr" v-model="user.email_usuario" placeholder="Email:">
                                                            <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarEmail()" style="border-radius:0px">Salvar</button>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="form-group col-md-12 row" style="padding-left:20px">
                                                            <label for="ocupUsr" class="col-12" style="margin-left:-15px">Ocupação</label>
                                                            <input type="email" class="form-control col-md-9" id="ocupUsr" v-model="user.ocupacao_usuario" placeholder="Ocupação:">
                                                            <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarOcupacao()" style="border-radius:0px">Salvar</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>





                                        <div id="pessoal" class="tab-pane fade">
                                            <div class="clearfix">
                                                <div class="col-12">
                                                    <div class="row">    
                                                        <div class="col-12">
                                                            <p class="pull-left" style="width:auto;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;">Informações pessoais</p>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top:40px">
                                                        <div class="col-md-8">

                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 row" style="padding-left:20px">
                                                                    <label for="cellUsr" class="col-12" style="margin-left:-15px">Número de celular:</label>
                                                                    <input type="text" class="form-control col-md-9" id="cellUsr" v-model="user.telefone_usuario" placeholder="Número de celular: (xx) xxxxx-xxxx">
                                                                    <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarCelular()" style="border-radius:0px">Salvar</button>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 row" style="padding-left:20px">
                                                                    <label for="cpfUsr" class="col-12" style="margin-left:-15px">CPF:</label>
                                                                    <input type="text" class="form-control col-md-9" id="cpfUsr" v-model="user.cpf_usuario" placeholder="CPF: xxx.xxx.xxx-xx">
                                                                    <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarCpf()" style="border-radius:0px">Salvar</button>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 row" style="padding-left:20px">
                                                                    <label for="dtNascUsr" class="col-12" style="margin-left:-15px">Data de Nascimento</label>
                                                                    <input type="date" class="form-control col-md-9" id="dtNascUsr" v-model="user.dtnasc_usuario" placeholder="Data de Nascimento:">
                                                                    <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarDtNasc()" style="border-radius:0px">Salvar</button>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 row" style="padding-left:20px">
                                                                    <label for="sexoUsr" class="col-12" style="margin-left:-15px">Sexo</label>
                                                                    <select class="form-control col-md-9" id="sexoUsr" v-model="user.sexo_usuario" style="border-radius:0px;height:45px">
                                                                        <option value="Feminino">Feminino</option>
                                                                        <option value="Masculino">Masculino</option>
                                                                        <option value="P">Prefiro não informar </option>
                                                                    </select>
                                                                    <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarSexo()" style="border-radius:0px">Salvar</button>
                                                                </div>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 row" style="padding-left:20px">
                                                                    <label for="cidadeUsr" class="col-12" style="margin-left:-15px">Cidade</label>                                                                       
                                                                    <select class="form-control col-md-9" id="cidadeUsr" v-model="user.cidade_usuario" style="border-radius:0px;height:45px">
                                                                        <?php
                                                                        $user = new Usuario();    
                                                                        $cidades = $user->loadCity(); 
                                                                        foreach ($cidades as $key => $value) { ?>
                                                                            <option value="<?php echo $cidades[$key]['id_cidade']; ?>"><?php echo $cidades[$key]['des_nome']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarCidade()" style="border-radius:0px">Salvar</button>
                                                                </div>
                                                            </div>
                                                            
                                                            <hr style="margin-left:-10px; margiin-right:-10px">
                                                            <a v-on:click="deletarConta()" class="text-danger btn-link" style="cursor:pointer; margin-left:-10px;">Deletar minha conta</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>





                                        <div id="senha" class="tab-pane fade">
                                            <div class="clearfix">
                                                <div class="col-12">
                                                    <div class="row">    
                                                        <div class="col-12">
                                                            <p class="pull-left" style="width:auto;margin-top: 15px;margin-bottom:0px;font-weight:400;font-size:18px;">Alterar senha</p>
                                                        </div>
                                                    </div>
                                                    <div class="row" style="margin-top:40px">
                                                        <div class="col-md-8">

                                                            <div class="form-row">
                                                                <div class="form-group col-md-12 row" style="padding-left:20px">
                                                                    <!-- <label for="senhaUsr" class="col-12" style="margin-left:-15px">Nova senha:</label> -->
                                                                    <input type="password" class="form-control col-md-9" id="senhaUsr" v-model="senha" placeholder="Nova senha:"/>
                                                                </div>

                                                                <div class="form-group col-md-12 row" style="padding-left:20px">
                                                                    <!-- <label for="confirmSenhaUsr" class="col-12" style="margin-left:-15px">Repita a senha:</label> -->
                                                                    <input type="password" class="form-control col-md-9" id="confirmSenhaUsr" v-model="confirmSenha" placeholder="Repita a senha:">
                                                                    <button type="button" class="btn btn-primary col-md-2" v-on:click="salvarSenha()" style="border-radius:0px">Salvar</button>
                                                                    <p><sub>A senha deve conter no mínimo 8 caracteres.</sub></p>
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
        </section>
    </div>







<?php include('_includes'.DS.'footer.php'); ?>
<script src="app/view/_js/configs_vue.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</body>
</html>