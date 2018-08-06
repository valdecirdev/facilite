<?php

    namespace model;

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

        public function experiencias()
        {
            return $this->hasMany(ExperienciaModel::class, 'id_usuario', 'id_usuario');
        }

        public function formacoes()
        {
            return $this->hasMany(FormacaoModel::class, 'id_usuario', 'id_usuario');
        }

        public function habilidades()
        {
            return $this->hasMany(HabilidadeUsuarioModel::class, 'id_usuario', 'id_usuario');
        }

        public function anuncios()
        {
            return $this->hasMany(AnuncioModel::class, 'id_usuario', 'id_usuario');
        }

        public function ligacoes()
        {
            return $this->hasMany(LigacaoModel::class, 'id_usuario', 'id_usuario');
        }

    }
