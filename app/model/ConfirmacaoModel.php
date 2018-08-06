<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class ConfirmacaoModel extends Model
{
    protected $fillable = [
        'id_confirmacao',
        'id_usuario',
        'des_hash'
    ];

    protected $table = 'tb_confirmacao_email';
    public $timestamps = false;
}
