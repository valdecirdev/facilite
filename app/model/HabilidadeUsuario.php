<?php
namespace model;

use \Illuminate\Database\Eloquent\Model;

class HabilidadeUsuario extends Model
{
    protected $fillable = [
        'id_habilidade_usuario',
        'id_habilidade',
        'id_usuario'
    ];

    protected $table = 'tb_habilidades_usuarios';
    public $timestamps = false;

    public function habilidade()
    {
        return $this->belongsTo(Habilidade::class, 'id_habilidade', 'id_habilidade');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

}

