<?php

namespace model;

use database\Database;
use \Illuminate\Database\Eloquent\Model;

class EstadoModel extends Model
{
    protected $fillable = [
        'id_estado',
        'des_nome',
        'des_uf',
        'id_pais'
    ];

    protected $table = 'tb_estados';
    public $timestamps = false;

    public function __construct()
    {
        parent::__construct();
        new Database();
    }

    public function pais()
    {
        return $this->belongsTo(PaisModel::class, 'id_pais', 'id_pais');
    }

    public function cidade()
    {
        $this->hasMany(CidadeModel::class, 'id_estado', 'id_estado');
    }
}