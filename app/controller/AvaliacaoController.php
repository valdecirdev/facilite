<?php

namespace controller;

use model\Avaliacao;

class AvaliacaoController
{
    //---------------------------------------------------------------------
    //  INSERT
    //---------------------------------------------------------------------
    public function avaliar (array $values)
    {
        $avaliacao = new Avaliacao();
        $avaliacao->id_usuario = $values['id_usuario'];
        $avaliacao->id_anuncio = $values['id_anuncio'];
        $avaliacao->des_comentario = $values['comentario'];
        $avaliacao->des_nota = $values['nota'];
        $avaliacao->save();
        // return $avaliacao->id;
    }

        
}