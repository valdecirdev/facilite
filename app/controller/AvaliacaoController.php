<?php

namespace Controller;

use Models\Avaliacao;
use Core\Controller;

class AvaliacaoController extends Controller
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