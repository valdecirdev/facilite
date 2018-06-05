<?php
    require_once('../view/config.php');

    class Habilidade {

        public function loadByID(int $id):HabilidadeModel{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_habilidades_usuario WHERE id_habilidade = :ID", array(
                ":ID"=>$id
            ));
            $habilidade =  new HabilidadeModel();
            if(count($result)>0){
                self::setData($habilidade,$result[0]);
            }
            return $habilidade;
        }

        public function loadByUser(int $id):array{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_habilidades,tb_habilidades_usuarios WHERE tb_habilidades_usuarios.id_usuario = :ID AND tb_habilidades_usuarios.id_habilidade = tb_habilidades.id_habilidade ", array(
                ":ID"=>$id
            ));
            $habilidade = array();
            foreach ($result as $key => $value) {
                $habilidade[$key] = new HabilidadeModel();
                self::setData($habilidade[$key],$result[$key]);
            }
            return $habilidade;
        }

        public function insert(array $values){
            $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $nivel = filter_var($values['des_nivel'], FILTER_SANITIZE_NUMBER_INT);
            $sql = new Sql();
            $results = $sql->select("INSERT INTO tb_habilidades_usuarios(id_usuario, des_descricao) VALUES(:ID_USUARIO, :DESCR)", array(
                ':ID_USUARIO'=>$values['id_usuario'],
                ':DESCR'=>$descr
            ));
        }
        
        public function update(array $values){
            $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $nivel = filter_var($values['des_nivel'], FILTER_SANITIZE_NUMBER_INT);
            $sql = new Sql();
            $sql->query("UPDATE tb_habilidades_usuarios SET id_usuario = :ID_USUARIO, des_descricao = :DESCR WHERE id_habilidade = :ID", array(
                ':ID_USUARIO'=>$values['id_usuario'],
                ':DESCR'=>$descr,
                ':ID'=>$values['id_habilidade']
            ));
        }
    
    
        public function delete(int $id){
            $sql = new Sql();
            $sql->query("DELETE FROM tb_habilidades_usuarios WHERE id_habilidade = :ID", array(
                ":ID"=>$id
            ));            
        }

        public function setData(HabilidadeModel $habilidade, array $data){
            $habilidade->setIdHabilidade($data['id_habilidade']);
            $habilidade->setIdUsuarioHabilidade($data['id_usuario']);
            $habilidade->setDescricaoHabilidade($data['des_descricao']);
        }

        
    }