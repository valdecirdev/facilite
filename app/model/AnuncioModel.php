<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class AnuncioModel extends Model
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
        return $this->belongsTo(UsuarioModel::class, 'id_usuario', 'id_usuario');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class, 'id_categoria', 'id_categoria');
    }

    public function modalidade()
    {
        return $this->belongsTo(ModalidadeModel::class, 'id_modalidade', 'id_modalidade');
    }

}
