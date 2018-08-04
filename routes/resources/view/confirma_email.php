<?php

    use controller\{Confirmacao, Usuario};

    if ((isset($_GET['hash']))) {
        $confirm = new Confirmacao();
        $infos = $confirm->loadByHash($_GET['hash']);
        $user = new Usuario();
        $user->gen_update('des_status', 'Ativo', $infos[0]['id_usuario']);
        $confirm->delete($infos[0]['id_confirmacao']);

        echo "<h4>Ativado com sucesso</h4>";
    }