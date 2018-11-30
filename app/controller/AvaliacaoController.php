<?php

namespace Controller;

use Models\{Avaliacao, Usuario, Anuncio};
use Core\Controller;

class AvaliacaoController extends Controller
{

    public function avaliar (array $values)
    {
        $avaliacao = new Avaliacao();
        $avaliacao->id_usuario = $values['id_usuario'];
        $avaliacao->id_anuncio = $values['id_anuncio'];
        $avaliacao->des_comentario = $values['comentario'];
        $avaliacao->des_nota = $values['nota'];
        $avaliacao->save();

        $this->alteraNota($values['id_anuncio']);
    }

    public function alteraNota($id_anuncio)
    {
        $anuncio = Anuncio::where('id_anuncio', $id_anuncio)->get();
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
        $nota = number_format($soma_nota/$n_avaliacoes, 1, ',', '');
        Usuario::where('id_usuario', $anunciante[0]->id_usuario)->update(['des_nota' => $nota]);
    }
        
}