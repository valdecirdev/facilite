<?php

    namespace Models;

    use \Illuminate\Database\Eloquent\Model;

    class Habilidade extends Model
    {
        protected $fillable = [
            'id_habilidade',
            'des_descricao',
            'des_status'
        ];

        protected $table = 'tb_habilidades';
        public $timestamps = false;

        public function usuario()
        {
            $this->hasMany(HabilidadeUsuario::class, 'id_habilidade', 'id_habilidade');
        }

    }
