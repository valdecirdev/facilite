<?php

namespace model;

use database\Database;
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

    public function __construct()
    {
        parent::__construct();
        new Database();
    }
}