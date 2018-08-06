<?php

namespace model;

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

    public function usuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario', 'id_usuario');
    }

}

