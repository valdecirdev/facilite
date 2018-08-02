<?php

    namespace model;

    use database\Database;
    use \Illuminate\Database\Eloquent\Model;

    class HabilidadeModel extends Model
    {
        protected $fillable = [
            'id_habilidade',
            'des_descricao',
            'des_status'
        ];

        protected $table = 'tb_habilidades';
        public $timestamps = false;

        public function __construct()
        {
            parent::__construct();
            new Database();
        }

        public function relatedHabilidadeUsuario()
        {
            $this->hasMany(HabilidadeUsuarioModel::class, 'id_habilidade', 'id_habilidade');
        }

    }
