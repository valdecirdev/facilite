<?php

namespace controller;

use model\ConfirmacaoModel;

class Confirmacao
{

    public function insert(ConfirmacaoModel $confirmacao): void
    {
        $confirm = new ConfirmacaoModel();
        $confirm->id_usuario = $confirmacao->getAttribute('id_usuario');
        $confirm->des_hash = $confirmacao->getAttribute('des_hash');
        $confirm->save();
    }

    public function loadByHash($hash)
    {
        $confirmacao = ConfirmacaoModel::where('des_hash', '=', $hash)->get();
        return $confirmacao;
    }

    public function delete(int $id): void
    {
        ConfirmacaoModel::where('id_confirmacao', '=', $id)->delete();
    }

}