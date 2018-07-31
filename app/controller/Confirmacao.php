<?php

namespace controller;

use model\ConfirmacaoModel;

class Confirmacao
{

    public function insert($confirmacao)
    {
        $confirm = new ConfirmacaoModel();
        $confirm->insert($confirmacao);
    }

    public function loadByHash($hash)
    {
        $confirm = new ConfirmacaoModel();
        return $confirm->loadByHash($hash);
    }

    public function delete(int $id)
    {
        $confirm = new ConfirmacaoModel();
        $confirm->delete($id);
    }

}