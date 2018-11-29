<?php

namespace Models;

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
        return $this->hasOne(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function categoria()
    {
        return $this->hasOne(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function modalidade()
    {
        return $this->hasOne(Modalidade::class, 'id_modalidade', 'id_modalidade');
    }

    public function avaliacoes()
    {
        return $this->belongsTo(Avaliacao::class, 'id_anuncio', 'id_anuncio');
    }

}
