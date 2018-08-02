<?php

namespace model;

use database\Database;
use \Illuminate\Database\Eloquent\Model;

class CidadeModel extends Model
{
    protected $fillable = [
        'id_cidade',
        'des_nome',
        'id_estado'
    ];

    protected $table = 'tb_cidades';
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        new Database();
    }

    public function estado()
    {
        return $this->belongsTo(EstadoModel::class, 'id_estado', 'id_estado');
    }
}