<?php

    namespace model;

    use database\Database;
    use \Illuminate\Database\Eloquent\Model;

    class ModalidadeModel extends Model
    {
        protected $fillable = [
            'id_modalidade',
            'des_descricao'
        ];

        protected $table = 'tb_modalidades';
        public $timestamps = false;

    }
