<?php use Controller\{MensagemController}; ?>

<nav class="d-print-none navbar navbar-expand-md navbar-dark">
    <a class="navbar-brand" href="/home" style="margin-right:50px">
        <div class="brand">
            <img src="/img/logo.png" alt="" height="30px">
        </div>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="input-group col-md-6 search-group">
            <form action="/search" method="GET" style="width:100%">
                <input type="text" name="q" class="pull-left campo-busca form-control" placeholder="Encontre o que você precisa!" value="<?php if(isset($_GET['q'])){echo $_GET['q'];} ?>">
                <div class="input-group-append">
                    <button class="btn btn-busca" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <ul class="nav navbar-nav ml-auto">

        <?php if(guest()) { ?>
            <li class="nav-item">
                <?php
                    if((isset($_GET['returnUrl']))&&(!is_null($_GET['returnUrl']))){
                        $url = $_GET['returnUrl'];
                    }else{
                        $uri = explode('/', $_SERVER["REQUEST_URI"]);
                        $url = $uri[count($uri)-1];
                        if($uri[count($uri)-2] == 'servico'){
                            $url = 'servico/'.$url;
                        }
                    }
                ?>
                <a href="/identifique-se?returnUrl=<?=$url;?>" class="nav-link text-white" style="font-size: 16px;">
                    <i class="fas fa-user" style="margin-right:7px;"></i> Entrar
                </a>
            </li>
            <li class="nav-item">
                <a href="/cadastre-se?returnUrl=<?=$url;?>" class="btn btn-primary col-12" style="padding: 7px 25px;background-color:#02b3e4;border-color:#02b3e4;color:#fff !important;border-radius:3px !important;box-shadow: 3px 3px 5px 0px rgba(0,0,0,0.05)">
                    Cadastrar-se
                </a>
            </li>
        <?php } else { ?>
            <li class="nav-item">
                <a href="messages" class="nav-link text-white" style="font-size: 16px;margin-top:-2px">
                <i class="fas fa-comment"></i>
                <?php
                    $countNewMessages = new MensagemController();
                    $countNewMessages = $countNewMessages->newMessagesCount($_SESSION['id']);
                ?>
                <span class="badge badge-light" id="countNewMessages" style="margin-left:-10px;font-size:10px;color:#fff;position:float;background-color:#e74c3c;"><?=$countNewMessages;?></span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a aria-label="Meu perfil" class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 16px;">
                    <img class="float-left img-nav-profile rounded-circle" src="/img/profile/<?=$logged_user->des_foto;?>" height="25" width="25" style="margin-top:-2px">
                    <span class="float-left clearfix d-sm-inline-block text-white" id="navbar-username" style="margin-top:-2px;margin-left:8px;margin-right:8px"><?=$logged_user->des_nome_exibicao;?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="min-width:200px;border-radius: 8px;" aria-label="navbarDropdownMenuLink">
                    <div id="dropdown-logged-user" class="row" style="padding: 10px 10px 0 0;width:100%;margin-bottom:-12px;margin-left:0">
                        <div class="col-12 text-center">
                            <a class="img-profile linkSlug" href="/<?=$logged_user->des_slug;?>"><img class="img-nav-dropdown rounded-circle" src="/img/profile/<?=$logged_user->des_foto;?>" height="120" width="120"></a>
                            <a class="linkSlug" href="/<?=$logged_user->des_slug; ?>"><p style="color:#8b8b8b">Perfil <span class="text-warning">40%</span> completo</p></a>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-muted" href="/configuracoes"><i class="fas fa-cogs" style="margin-right:5px; font-size:13px; margin-left: -2px"></i> Configurações</a>
                    <a class="dropdown-item text-muted" href="/configuracoes"><i class="fas fa-lock" style="margin-right:8px; font-size:13px"></i> Alterar Senha</a>
                    <button type="button" id="logout-user" class="dropdown-item text-muted" style="cursor:pointer;"><i class="fas fa-power-off" style="margin-right:6px; font-size:13px"></i> Sair</button>
                </div>
            </li>
        <?php } ?>
        </ul>
    </div>
</nav>
