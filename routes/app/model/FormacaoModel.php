<?php

    namespace model;

    use database\Database;
    use \Illuminate\Database\Eloquent\Model;

    class FormacaoModel extends Model
    {
        protected $fillable = [
            'id_formacao',
            'id_usuario',
            'des_titulo',
            'des_descricao'
        ];

        protected $table = 'tb_formacoes';
        public $timestamps = false;
    }
