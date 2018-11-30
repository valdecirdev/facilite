<?php

namespace Controller;

use Models\{Avaliacao, Usuario, Anuncio};
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

        $anuncio = Anuncio::where('id_anuncio', $values['id_anuncio'])->get();
        $anunciante = Usuario::where('id_usuario', $anuncio[0]->id_usuario)->get();

        $soma_nota = 0;
        $n_avaliacoes = 0;
        $nota = 0;
        foreach ($anunciante[0]->anuncios()->get() as $key => $anuncio) {
            foreach($anuncio->avaliacoes()->get() as $key => $avaliacao) {
                $soma_nota += $avaliacao->des_nota;
                $n_avaliacoes++;
            }
        }
        $nota = $soma_nota/$n_avaliacoes;
        Usuario::where('id_usuario', $anunciante[0]->id_usuario)->update(['des_nota' => $nota]);
    }

        
}