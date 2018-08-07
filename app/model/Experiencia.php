<?php
//
namespace model;

use \Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{
    protected $fillable = [
        'id_experiencia',
        'id_usuario',
        'des_titulo',
        'des_descricao'
    ];

    protected $table = 'tb_experiencias';
    public $timestamps = false;

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

}
