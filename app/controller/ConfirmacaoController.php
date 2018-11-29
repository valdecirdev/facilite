<?php

namespace Controller;

use Models\Confirmacao;
use Core\Controller;

class ConfirmacaoController extends Controller
{

    public function insert(Confirmacao $confirmacao): void
    {
        $confirm = new Confirmacao();
        $confirm->id_usuario = $confirmacao->getAttribute('id_usuario');
        $confirm->des_hash = $confirmacao->getAttribute('des_hash');
        $confirm->save();
    }

    public function loadByHash($hash)
    {
        $confirmacao = Confirmacao::where('des_hash', '=', $hash)->get();
        return $confirmacao;
    }

    public function delete(int $id): void
    {
        Confirmacao::where('id_confirmacao', '=', $id)->delete();
    }

}