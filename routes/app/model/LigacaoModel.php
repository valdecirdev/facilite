<?php

namespace model;

use database\Database;
use \Illuminate\Database\Eloquent\Model;

class LigacaoModel extends Model
{
    protected $fillable = [
        'id_ligacao',
        'id_usuario',
        'id_contato',
        'dt_ligacao'
    ];

    protected $table = 'tb_ligacoes';
    public $timestamps = false;

}

