<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class PaisModel extends Model
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
        $this->hasMany(EstadoModel::class, 'id_pais', 'id_pais');
    }

}