<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class CategoriaModel extends Model
{
    protected $fillable = [
        'id_categoria',
        'des_categoria',
        'des_icone'
    ];

    protected $table = 'tb_categorias';
    public $timestamps = false;

    public function anuncio()
    {
        $this->hasMany(AnuncioModel::class, 'id_categoria', 'id_categoria');
    }
}