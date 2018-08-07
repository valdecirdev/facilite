<?php

    use controller\{ConfirmacaoController, UsuarioController};

    if ((isset($_GET['hash']))) {
        $confirm = new ConfirmacaoController();
        $infos = $confirm->loadByHash($_GET['hash']);
        $user = new UsuarioController();
        $user->gen_update('des_status', 'Ativo', $infos[0]['id_usuario']);
        $confirm->delete($infos[0]['id_confirmacao']);

        echo "<h4>Ativado com sucesso</h4>";
    }