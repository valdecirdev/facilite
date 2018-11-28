<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $fillable = [
        'id_avaliacao',
        'id_anuncio',
        'des_comentario',
        'des_nota',
        'id_usuario',
        'dt_comentario',
        'dt_atualizacao',
    ];

    protected $table = 'tb_avaliacoes';
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function anuncio()
    {
        return $this->belongsTo(Anuncio::class, 'id_anuncio', 'id_anuncio');
    }

}
