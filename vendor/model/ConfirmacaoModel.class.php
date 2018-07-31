<?php

namespace vendor\model;

use vendor\model\dao\Sql;

class ConfirmacaoModel
{

    public function insert($confirmacao)
    {
        $sql = new Sql();
        $sql->query("INSERT INTO tb_confirmacao_email(id_usuario, des_hash) VALUES (:IDUSUARIO, :DESHASH)", array(
            ":IDUSUARIO"=>$confirmacao->getIdUsuario(),
            ":DESHASH"=>$confirmacao->getDesHash()
        ));
    }

    public function loadByHash($hash)
    {
        $sql = new Sql();
        $result = $sql->select("SELECT id_usuario, id_confirmacao FROM tb_confirmacao_email WHERE des_hash = :DESHASH", array(
            ":DESHASH"=>$hash
        ));
        return $result;
    }

    public function delete(int $id)
    {
        $sql = new Sql();
        $result = $sql->query("DELETE FROM tb_confirmacao_email WHERE id_confirmacao = :ID", array(
            ":ID"=>$id
        ));
    }

}