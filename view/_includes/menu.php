<nav class="d-print-none navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="home">
        <div class="brand">
            <img src="view/_img/logo.png" alt="" height="30px">
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="input-group col-md-4 offset-md-3">
            <form action="search" method="GET" style="padding:0px;margin:0px; width:100%">
                <input type="text" name="q" class="pull-left campo-busca form-control" placeholder="Encontre o que você precisa!" aria-label="Encontre o que você precisa!" value="<?php if(isset($_GET['q'])){echo $_GET['q'];} ?>">
                <div class="input-group-append">
                    <button class="btn btn-busca" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <ul class="nav navbar-nav ml-auto">
        <?php if($_SESSION == NULL){
            if( $pg_title != ''){ echo '<li class="nav-item"><a class="nav-link text-white" href="home">Página Inicial</a></li>'; } ?>
            <li class="nav-item">
                <a class="nav-link text-white" data-toggle="modal" data-target="#registerModal">
                    <i class="fab fa-wpforms" style="margin-right:5px;"></i> Cadastrar-se
                </a>
            </li>
            <?php if( $pg_title != ''){ ?>
                <div class="dropdown nav-item">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user" style="margin-right:5px;"></i> Entrar
                    </a>
                    <div class="dropdown-menu" id="loginDropdown">
                        <!-- <div class="dropdown-arrow"></div> -->
                            <form action="" method="POST" class="px-4 py-3">
                                <div class="form-group">
                                    <label for="exampleDropdownFormEmail1">Email</label>
                                    <input type="email" class="form-control" id="login_des_email" name="login_des_email" placeholder="email@examplo.com">
                                </div>
                                <div class="form-group">
                                    <label for="exampleDropdownFormPassword1">Senha</label>
                                    <input type="password" class="form-control" name="des_senha" id="login_des_senha" placeholder="Senha">
                                </div>
                                <div id="login-alert" class="d-none col-12" style="padding:0px;margin-bottom:10px;margin-top:-5px;">
                                    <strong style="color:red;font-size:13px;">Email e/ou senha incorreto!</strong>
                                </div>
                                <div class="clearfix" style="margin-bottom: -15px">
                                    <button type="button" id="login-user" class="btn btn-fc-primary col-12 btn-radius">Conectar</button>
                                </div>
                            </form>
                        <div class="dropdown-divider"></div>
                        <div style="margin-top:-20px;" class="d-lg-block">
                            <a class="dropdown-item text-muted" data-toggle="modal" data-target="#registerModal" >Ainda não tem uma conta? Cadastre-se</a>
                        </div>
                    </div>
                </div>
            <?php } 
        }else{ 
            if( $pg_title != ''){ echo '<li class="nav-item"><a class="nav-link text-white" href="home">Página Inicial</a></li>'; } ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php 
                        $loggedUser = new Usuario(); 
                        $loggedUser = $loggedUser->loadById($_SESSION['id']); 
                    ?>
                    <img class="img-nav-profile rounded-circle" src="view/_img/profile/<?php echo $loggedUser->getFotoUsuario(); ?>" height="25" width="25">
                    <span class="clearfix d-sm-inline-block text-white" id="navbar-username"><?php echo explode(' ', $loggedUser->getNomeSimplesUsuario())[0] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="min-width:300px;border-radius: 2px;" aria-labelledby="navbarDropdownMenuLink">
                    <div id="dropdown-logged-user" class="row" style="padding:10px;padding-left:0px;padding-bottom:0px;width:100%;margin-bottom:-12px;margin-left:0px">
                        <div class="col-2">
                            <img class="img-nav-profile rounded-circle" src="view/_img/profile/<?php echo $loggedUser->getFotoUsuario(); ?>" height="40" width="40">
                        </div>
                        <div class="col-10" style="padding-left:20px;">
                            <p style="padding:0px;margin-top:-7px;font-size: 15px;font-weight:bold;"><?php echo $loggedUser->getNomeSimplesUsuario();?></p>
                            <p style="padding:0px;margin-top:-17px;font-size:14px"><?php echo $loggedUser->getEmailUsuario();?></p>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-muted" href="<?php echo $loggedUser->getSlugUsuario(); ?>"><i class="fa fa-user" style="margin-right:10px;"></i> Ver perfil</a>
                    <button type="button" id="logout-user" class="dropdown-item text-danger" style="cursor:pointer;"><i class="fas fa-sign-out-alt" style="margin-right:6px;"></i> Sair</button>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
</nav>
