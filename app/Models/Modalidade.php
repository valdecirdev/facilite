<?php

    namespace Models;

    use \Illuminate\Database\Eloquent\Model;

    class Modalidade extends Model
    {
        protected $fillable = [
            'id_modalidade',
            'des_descricao'
        ];

        protected $table = 'tb_modalidades';
        public $timestamps = false;

    }
