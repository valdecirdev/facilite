<?php

    namespace model;

    use \Illuminate\Database\Eloquent\Model;

    class ModalidadeModel extends Model
    {
        protected $fillable = [
            'id_modalidade',
            'des_descricao'
        ];

        protected $table = 'tb_modalidades';
        public $timestamps = false;

        public function anuncio()
        {
            $this->hasMany(AnuncioModel::class, 'id_modalidade', 'id_modalidade');
        }
    }
