<?php


    use vendor\controller\{Usuario, Confirmacao};

    require ("../bootstrap/bootstrap.php");

    if ((isset($_GET['hash']))) {
        $confirm = new Confirmacao();
        $infos = $confirm->loadByHash($_GET['hash']);
        $user = new Usuario();
        $values = array(
            "campo"=>"des_status",
            "valor"=>"Ativo",
            "id"=>$infos[0]['id_usuario']
        );
        $user->gen_update($values);
        $confirm->delete($infos[0]['id_confirmacao']);

        echo "<h4>Ativado com sucesso</h4>";
    }