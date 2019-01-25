<?php

namespace Controller;

use Models\Ligacao;
use Core\Controller;
    
    class LigacaoController extends Controller
    {

        public function add_ligacao(int $id_usuario,int $id_contato): void
        {
            $ligacao = new Ligacao;
            $ligacao->id_usuario = $id_usuario;
            $ligacao->id_contato = $id_contato;
            $ligacao->save();
        }

        public function rm_ligacao(int $id_usuario, int $id_contato): void
        {
            Ligacao::where([
                ['id_usuario', '=', $id_usuario],
                ['id_contato', '=', $id_contato],
            ])->delete();
        }

    }
