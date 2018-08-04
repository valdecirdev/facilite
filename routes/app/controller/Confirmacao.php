<?php

namespace controller;

use model\ConfirmacaoModel;
use model\object\ObjConfirmacao;

class Confirmacao
{

    public function insert(ObjConfirmacao $confirmacao)
    {
        $confirm = new ConfirmacaoModel();
        $confirm->id_usuario = $confirmacao->getIdUsuario();
        $confirm->des_hash = $confirmacao->getDesHash();
        $confirm->save();
    }

    public function loadByHash($hash)
    {
        $confirmacao = ConfirmacaoModel::where('des_hash', '=', $hash)->get();
        return $confirmacao;
    }

    public function delete(int $id)
    {
        ConfirmacaoModel::where('id_confirmacao', '=', $id)->delete();
    }

}