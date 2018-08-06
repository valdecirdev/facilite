<?php

    namespace model;

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

        public function usuario()
        {
            return $this->belongsTo(UsuarioModel::class, 'id_usuario', 'id_usuario');
        }

    }
