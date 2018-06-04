<?php
    require_once('../view/config.php');

    class Ligacao {

        public function loadById(int $id_usuario,int $id_contato){
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_ligacoes WHERE id_usuario = :ID_USUARIO AND id_contato = :ID_CONTATO", array(
                ":ID_USUARIO"=>$id_usuario,
                ":ID_CONTATO"=>$id_contato
            ));
            $ligacao = new LigacaoModel();
            if(count($result)>0){
                self::setData($ligacao,$result[0]);
                return $ligacao;
            }
            return NULL;
        }

        public function loadByUser(int $id,int $limite): array{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_ligacoes WHERE id_usuario = :ID LIMIT $limite", array(
                ":ID"=>$id
            ));
            $ligacao = array();
            foreach ($result as $key => $value) {
                $ligacao[$key] = new LigacaoModel();
                self::setData($ligacao[$key],$result[$key]);
            }
            return $ligacao;
        }

        public function add_ligacao(int $id_usuario,int $id_contato){
            $sql = new Sql();
            if($id_usuario != $id_contato){
                $results = $sql->query("INSERT INTO tb_ligacoes(id_usuario, id_contato) VALUES(:ID_USUARIO, :ID_CONTATO)", array(
                    ':ID_USUARIO'=>$id_usuario,
                    ':ID_CONTATO'=>$id_contato
                ));
            }
        }

        public function rem_ligacao(int $id_usuario,int $id_contato){
            $sql = new Sql();
            if($id_usuario != $id_contato){
                $results = $sql->query("DELETE FROM tb_ligacoes WHERE id_usuario = :ID_USUARIO AND id_contato = :ID_CONTATO", array(
                    ':ID_USUARIO'=>$id_usuario,
                    ':ID_CONTATO'=>$id_contato
                ));
            }
        }

        public function setData(LigacaoModel $ligacao,array $data){
            $ligacao->setIdLigacao($data['id_ligacao']);
            $ligacao->setIdUsuarioLigacao($data['id_usuario']);
            $ligacao->setIdContatoLigacao($data['id_contato']);
            $ligacao->setDtLigacao($data['dt_ligacao']);
        }
    
    }










    
    
    







