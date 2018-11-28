<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class Plano extends Model
{
    protected $fillable = [
        'id_plano',
        'des_titulo',
        'des_descricao',
        'des_preco'
    ];

    protected $table = 'tb_planos';
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

}
