<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class Ligacao extends Model
{
    protected $fillable = [
        'id_ligacao',
        'id_usuario',
        'id_contato',
        'dt_ligacao'
    ];

    protected $table = 'tb_ligacoes';
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function contato()
    {
        return $this->belongsTo(Usuario::class, 'id_contato', 'id_usuario');
    }

}

