<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    protected $fillable = [
        'id_anuncio',
        'id_categoria',
        'des_descricao',
        'des_preco',
        'id_modalidade',
        'des_disponibilidade'
    ];

    protected $table = 'tb_anuncios';
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function modalidade()
    {
        return $this->belongsTo(Modalidade::class, 'id_modalidade', 'id_modalidade');
    }

}
