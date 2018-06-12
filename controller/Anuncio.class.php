<?php
    require_once('../view/config.php');

    class Anuncio {
       
        public function loadByID(int $id):AnuncioModel{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_anuncios WHERE id_anuncio = :ID", array(
                ":ID"=>$id
            ));
            $anuncio = new AnuncioModel();
            if(count($result)>0){    
                $this->setData($anuncio,$result[0]);
            }
            return $anuncio;
        }

        public function loadByUser(int $id):array{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_anuncios WHERE id_usuario = :ID", array(
                ":ID"=>$id
            ));
            $anuncio = array();
            foreach ($result as $key => $value) {
                $anuncio[$key] = new AnuncioModel();
                $this->setData($anuncio[$key],$result[$key]);
            }
            return $anuncio;
        }

        public function insert(array $values){
            $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $preco = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
            $dispon = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);
            $sql = new Sql();
            $results = $sql->query("INSERT INTO tb_anuncios(id_usuario, id_categoria , des_descricao, des_preco, id_modalidade, des_disponibilidade) 
            VALUES(:ID_USER, :ID_CAT, :DES_DESCR, :DESC_PREC, :ID_MODAL, :DES_DISPON)", array(
                ':ID_USER'=>$values['id_usuario'],
                ':ID_CAT'=>$values['id_categoria'],
                ':DES_DESCR'=>$descr,
                ':DESC_PREC'=>$preco,
                ':ID_MODAL'=>$values['id_modalidade'],
                ':DES_DISPON'=>$dispon
            ));
        }

        public function update(array $values){
            $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $preco = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
            $dispon = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);
            $sql = new Sql();
            $results = $sql->query("UPDATE tb_anuncios SET id_categoria = :ID_CAT, des_descricao = :DES_DESCR, des_preco = :DESC_PREC, id_modalidade = :ID_MODAL, des_disponibilidade = :DES_DISPON WHERE id_anuncio = :ID", array(
                ':ID_CAT'=>$values['id_categoria'],
                ':DES_DESCR'=>$descr,
                ':DESC_PREC'=>$preco,
                ':ID_MODAL'=>$values['id_modalidade'],
                ':DES_DISPON'=>$dispon,
                ':ID'=>$values['id_anuncio']
            ));
        }

        public function delete(int $id){
            $sql = new Sql();
            $sql->query("DELETE FROM tb_anuncios WHERE id_anuncio = :ID", array(
                ":ID"=>$id
            ));            
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