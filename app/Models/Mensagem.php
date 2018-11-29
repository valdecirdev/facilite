<?php

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $fillable = [
        'id_mensagem',
        'id_chat',
        'id_remetente',
        'des_mensagem',
        'dt_envio',
        'des_status',
    ];

    protected $table = 'tb_mensagens';
    public $timestamps = false;

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'id_chat', 'id_chat');
    }

}
