<?php
//
namespace model;

use database\Database;
use \Illuminate\Database\Eloquent\Model;

class ExperienciaModel extends Model
{
    protected $fillable = [
        'id_experiencia',
        'id_usuario',
        'des_titulo',
        'des_descricao'
    ];

    protected $table = 'tb_experiencias';
    public $timestamps = false;

    public function __construct()
    {
        new Database();
    }
}
