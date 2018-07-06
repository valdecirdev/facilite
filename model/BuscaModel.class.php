<?php
    
    class BuscaModel
    {
       
        public function searchCount(string $q, $id)
        {
            $sql = new Sql();
            $result = $sql->select("SELECT COUNT(*) FROM tb_categorias,tb_anuncios, tb_usuarios WHERE ((tb_categorias.des_descricao LIKE :Q OR tb_usuarios.des_nome LIKE :Q OR tb_anuncios.des_descricao LIKE :Q) AND tb_categorias.id_categoria = tb_anuncios.id_categoria) AND tb_anuncios.id_usuario = tb_usuarios.id_usuario AND tb_anuncios.id_usuario != :ID", array(
                ":Q"=>'%'.$q.'%',
                ":ID"=>$id
            ));
            return $result[0]['COUNT(*)'];
        }

        public function search(string $q, $id, $limit, $to):array
        {
            $sql = new Sql();
            // $where = '';
            // $q = explode(" ", $q);
            $result = $sql->select("SELECT * FROM tb_categorias, tb_anuncios, tb_usuarios WHERE ((tb_categorias.des_descricao LIKE :Q OR tb_usuarios.des_nome LIKE :Q OR tb_anuncios.des_descricao LIKE :Q) AND tb_categorias.id_categoria = tb_anuncios.id_categoria) AND tb_anuncios.id_usuario = tb_usuarios.id_usuario AND tb_anuncios.id_usuario != :ID ORDER BY tb_anuncios.id_anuncio DESC LIMIT $limit, $to", array(
                ":Q"=>'%'.$q.'%',
                ":ID"=>$id
            ));
            $anuncio = array();
            foreach ($result as $key => $value) {
                $anuncio[$key] = new ObjAnuncio();
                $categoria[$key] = new Categoria();
                $modalidade[$key] = new Modalidade();
                $des_categoria = $categoria[$key]->loadByID($result[$key]['id_categoria']);
                $des_modalidade = $modalidade[$key]->loadByID($result[$key]['id_modalidade']);
                $this->setData($anuncio[$key],$result[$key], $des_categoria->getDescricaoCategoria(), $des_categoria->getIconeCategoria(), $des_modalidade->getDescricaoModalidade());
            }
            return $anuncio;
        }

        public function setData (ObjAnuncio $anuncio, array $data, $des_categoria, $des_icone_categoria, $des_modalidade)
        {
            $anuncio->setIdAnuncio($data['id_anuncio']);
            $anuncio->setIdUsuarioAnuncio($data['id_usuario']);
            $anuncio->setIdCategoriaAnuncio($data['id_categoria']);
            $anuncio->setCategoriaAnuncio($des_categoria);
            $anuncio->setIconeCategoriaAnuncio($des_icone_categoria);
            $anuncio->setDescricaoAnuncio($data['des_descricao']);
            $preco = number_format($data['des_preco'],2,",",".");
            $anuncio->setPrecoAnuncio($preco);
            $anuncio->setIdModalidadeAnuncio($data['id_modalidade']);
            $anuncio->setModalidadeAnuncio($des_modalidade);
            $anuncio->setDisponibilidadeAnuncio($data['des_disponibilidade']);
        }

        
    }