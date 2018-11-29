<?php

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class Cidade extends Model
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
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

    public function usuario()
    {
        return $this->hasMany(Usuario::class, 'id_cidade', 'id_cidade');
    }

}