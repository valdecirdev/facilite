<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $fillable = [
        'id_pais',
        'des_nome',
        'des_sigla'
    ];

    protected $table = 'tb_paises';
    public $timestamps = false;

    public function estado()
    {
        $this->hasMany(Estado::class, 'id_pais', 'id_pais');
    }

}