<?php
    require_once('../view/config.php');

    class Busca {
       
        public function search(string $q, $id):array{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_categorias,tb_anuncios, tb_usuarios WHERE ((tb_categorias.des_descricao LIKE :Q OR tb_usuarios.des_nome LIKE :Q) AND tb_categorias.id_categoria = tb_anuncios.id_categoria) AND tb_anuncios.id_usuario = tb_usuarios.id_usuario AND tb_anuncios.id_usuario != :ID", array(
                ":Q"=>'%'.$q.'%',
                ":ID"=>$id
            ));
            $anuncio = array();
            foreach ($result as $key => $value) {
                $anuncio[$key] = new AnuncioModel();
                self::setData($anuncio[$key],$result[$key]);
            }
            return $anuncio;
        }


        public function setData(AnuncioModel $anuncio,array $data){
            $anuncio->setIdAnuncio($data['id_anuncio']);
            $anuncio->setIdUsuarioAnuncio($data['id_usuario']);
            $anuncio->setIdCategoriaAnuncio($data['id_categoria']);
            $anuncio->setDescricaoAnuncio($data['des_descricao']);
            $preco = number_format($data['des_preco'],2,",",".");
            $anuncio->setPrecoAnuncio($preco);
            $anuncio->setIdModalidadeAnuncio($data['id_modalidade']);
            $anuncio->setDisponibilidadeAnuncio($data['des_disponibilidade']);
        }

        
    }