<?php

namespace model;

use \Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable = [
        'id_estado',
        'des_nome',
        'des_uf',
        'id_pais'
    ];

    protected $table = 'tb_estados';
    public $timestamps = false;

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'id_pais', 'id_pais');
    }

    public function cidade()
    {
        $this->hasMany(Cidade::class, 'id_estado', 'id_estado');
    }
}