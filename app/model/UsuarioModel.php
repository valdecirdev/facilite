<?php

    namespace model;

    use database\Database;
    use \Illuminate\Database\Eloquent\Model;

    class UsuarioModel extends Model
    {

        const CREATED_AT = 'dt_cadastro';

        protected $fillable = [
            'id_usuario',
            'des_slug',
            'des_email',
            'des_senha',
            'des_nome',
            'des_sexo',
            'dt_nasc',
            'des_apresentacao',
            'des_cpf',
            'des_foto',
            'id_cidade',
            'des_telefone',
            'des_ocupacao',
            'des_status',
            'dt_cadastro'
        ];

        protected $table = 'tb_usuarios';
        public $timestamps = false;

        public function __construct()
        {
            parent::__construct();
            new Database();
        }

        public function relatedHabilidadeUsuario()
        {
            return $this->hasMany(HabilidadeUsuarioModel::class, 'id_usuario', 'id_usuario');
        }

    }
