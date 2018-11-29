<?php

    namespace Models;

    use \Illuminate\Database\Eloquent\Model;

    class Usuario extends Model
    {

        const CREATED_AT = 'dt_cadastro';

        protected $fillable = [
            'id_usuario',
            'id_plano',
            'des_slug',
            'des_email',
            'des_senha',
            'des_nome',
            'des_nome_exibicao',
            'des_sexo',
            'dt_nasc',
            'des_apresentacao',
            'des_cpf',
            'des_foto',
            'des_cep',
            'id_cidade',
            'des_telefone',
            'des_ocupacao',
            'des_status',
            'dt_cadastro'
        ];

        protected $table = 'tb_usuarios';
        public $timestamps = false;

        public function slugGenerator(string $fullname): string
        {
            $fullname = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $fullName ) );
            $fullname = explode(' ', $fullname);
            $cont = null; $lastname = "";
            if (count($fullname) > 1) $lastname = $fullname[count($fullname)-1];

            do {
                $slug = $fullname[0].$lastname.$cont;
                $cont++;
            } while ($self::slugExists($slug));
            return $slug;
        }

        public function slugExists(string $slug): bool
        {
            return self::where('des_slug', $slug)->exists();
        }

        public function emailExists(string $email)
        {
            return self::where('des_email', $email)->exists();
        }

        

        public function avaliacoes()
        {
            return $this->hasMany(Avaliacao::class, 'id_usuario', 'id_usuario')->orderby('dt_atualizacao', 'desc');
        }

        public function experiencias()
        {
            return $this->hasMany(Experiencia::class, 'id_usuario', 'id_usuario')->orderby('des_de', 'desc');
        }

        public function formacoes()
        {
            return $this->hasMany(Formacao::class, 'id_usuario', 'id_usuario');
        }

        public function habilidades()
        {
            return $this->hasMany(HabilidadeUsuario::class, 'id_usuario', 'id_usuario');
        }

        public function anuncios()
        {
            return $this->hasMany(Anuncio::class, 'id_usuario', 'id_usuario');
        }

        public function ligacoes()
        {
            return $this->hasMany(Ligacao::class, 'id_usuario', 'id_usuario');
        }

        public function cidade()
        {
            return $this->belongsTo(Cidade::class, 'id_cidade', 'id_cidade');
        }

        public function plano()
        {
            return $this->belongsTo(Plano::class, 'id_plano', 'id_plano');
        }

    }
