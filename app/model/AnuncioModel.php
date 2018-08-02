<?php

namespace model;

use database\Database;
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

    public function __construct()
    {
        parent::__construct();
        new Database();
    }

}
