<?php
namespace model;

use database\Database;
use \Illuminate\Database\Eloquent\Model;

class HabilidadeUsuarioModel extends Model
{
    protected $fillable = [
        'id_habilidade_usuario',
        'id_habilidade',
        'id_usuario'
    ];

    protected $table = 'tb_habilidades_usuarios';
    public $timestamps = false;

    public function __construct()
    {
        new Database();
    }

    public function relatedHabilidade()
    {
        return $this->belongsTo(HabilidadeModel::class, 'id_habilidade', 'id_habilidade');
    }

    public function relatedUsuario()
    {
        return $this->belongsTo(UsuarioModel::class, 'id_usuario', 'id_usuario');
    }

}

