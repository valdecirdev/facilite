<?php

namespace Models;

use \Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'id_chat',
        'id_anunciante',
        'id_contratante',
        'des_status',
    ];

    protected $table = 'tb_chats';
    public $timestamps = false;

    public function mensagem()
    {
        $this->hasMany(Mensagem::class, 'id_chat', 'id_chat');
    }

    public function anunciante()
    {
        return $this->belongsTo(Usuario::class, 'id_anunciante', 'id_usuario');
    }

    public function contratante()
    {
        return $this->belongsTo(Usuario::class, 'id_contratante', 'id_usuario');
    }

}
