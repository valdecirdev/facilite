<?php

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'id_categoria',
        'des_categoria',
        'des_icone'
    ];

    protected $table = 'tb_categorias';
    public $timestamps = false;

}