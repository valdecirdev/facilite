<?php

namespace model;

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

    public function estado()
    {
        return $this->belongsTo(EstadoModel::class, 'id_estado', 'id_estado');
    }
}