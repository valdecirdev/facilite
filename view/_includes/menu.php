<nav class="d-print-none navbar navbar-expand-md navbar-dark">
    <a class="navbar-brand" href="home" style="margin-right:50px">
        <div class="brand">
            <img src="view/_img/logo.png" alt="" height="30px">
        </div>
    </a>
    <button class="navbar-toggler" type="button" aria-label="Exibir ou ocultar menu" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="input-group col-md-6 search-group">
            <form action="search" method="GET" style="width:100%">
                <input type="text" name="q" class="pull-left campo-busca form-control" placeholder="Encontre o que você precisa!" aria-label="Encontre o que você precisa!" value="<?php if(isset($_GET['q'])){echo $_GET['q'];} ?>">
                <div class="input-group-append">
                    <button class="btn btn-busca" type="submit" aria-label="Pesquisar"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <ul class="nav navbar-nav ml-auto">
        <?php if($_SESSION == NULL){
            //if( $pg_title != ''){ echo '<li class="nav-item"><a aria-label="Pagina inicial" class="nav-link text-white" href="home">Página INICIAL</a></li>'; } ?>
            <li class="nav-item" style="margin-right:15px">
                <a href="identifique-se" aria-label="Fazer Login" class="nav-link text-white" style="margin-top:-2px">
                    <i class="fas fa-user" style="margin-right:5px;"></i> Entrar
                </a>
            </li>
            <li class="nav-item">
                <a href="cadastre-se" aria-label="Fazer Cadastro" class="btn btn-primary col-12" style="padding-top:5px;padding-bottom:5px;background-color:#02b3e4;border-color:#02b3e4;color:#fff !important;border-radius:3px !important;box-shadow: 3px 3px 5px 0px rgba(0,0,0,0.05)">
                    Cadastrar-se
                </a>
            </li>
        <?php }else{ ?>
            <li class="nav-item dropdown">
                <a aria-label="Meu perfil" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php 
                        $loggedUser = new Usuario(); 
                        $loggedUser = $loggedUser->loadById($_SESSION['id']); 
                    ?>
                    <img class="float-left img-nav-profile rounded-circle" src="view/_img/profile/<?php echo $loggedUser->getFotoUsuario(); ?>" height="25" width="25">
                    <span class="float-left clearfix d-sm-inline-block text-white" id="navbar-username" style="margin-top:-3px;margin-left:3px;margin-right:3px"><?php echo explode(' ', $loggedUser->getNomeSimplesUsuario())[0] ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="min-width:300px;border-radius: 2px;" aria-label="navbarDropdownMenuLink">
                    <div id="dropdown-logged-user" class="row" style="padding:10px;padding-left:0px;padding-bottom:0px;width:100%;margin-bottom:-12px;margin-left:0px">
                        <div class="col-2">
                            <img class="img-nav-profile rounded-circle" src="view/_img/profile/<?php echo $loggedUser->getFotoUsuario(); ?>" height="40" width="40">
                        </div>
                        <div class="col-10" style="padding-left:20px;">
                            <p id="nomeSimplesLogged" style="padding:0px;margin-top:-7px;font-size: 15px;font-weight:bold;"><?php echo $loggedUser->getNomeSimplesUsuario();?></p>
                            <p id="emailLogged" style="padding:0px;margin-top:-17px;font-size:14px"><?php echo $loggedUser->getEmailUsuario();?></p>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-muted" href="<?php echo $loggedUser->getSlugUsuario(); ?>">Visualizar perfil <span style="padding:0px;margin-bottom:5px;font-size:13px;color:#8b8b8b">- 50% Completo</span></a>
                    <a class="dropdown-item text-muted" href="configuracoes">Configurações <span style="padding:0px;margin-bottom:5px;font-size:13px;color:#8b8b8b"></span></a>
                    <button type="button"  aria-label="Fazer Logout" id="logout-user" class="dropdown-item text-danger" style="cursor:pointer;">Sair</button>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
</nav>
