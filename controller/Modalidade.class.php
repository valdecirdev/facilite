<?php
    require_once('../view/config.php');

    class Modalidade {

        public function loadAll():array{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_modalidades");
            $modalidade =  array();
            foreach ($result as $key => $value) {
                $modalidade[$key] =  new ModalidadeModel();
                self::setData($modalidade[$key],$result[$key]);
            }
            return $modalidade; 
        }

        public function loadByID(int $id):ModalidadeModel{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_modalidades WHERE id_modalidade = :ID", array(
                ":ID"=>$id
            ));
            $modalidade =  new ModalidadeModel();
            if(count($result)>0){
                self::setData($modalidade,$result[0]);
            }
            return $modalidade;
        }

        public function setData(ModalidadeModel $modalidade,array $data){
            $modalidade->setIdModalidade($data['id_modalidade']);
            $modalidade->setDescricaoModalidade($data['des_descricao']);
        }
        
    }