<?php
    
    class Experiencia
    {

        public function loadByID(int $id):ObjExperiencia
        {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_experiencias WHERE id_experiencia = :ID", array(
                ":ID"=>$id
            ));
            $experiencia =  new ObjExperiencia();
            if (count($result)>0) {
                self::setData($experiencia,$result[0]);
            }
            return $experiencia;
        }

        public function loadByUser(int $id):array
        {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_experiencias WHERE id_usuario = :ID ORDER BY id_experiencia desc", array(
                ":ID"=>$id
            ));
            $experiencia = array();
            foreach ($result as $key => $value) {
                $experiencia[$key] = new ObjExperiencia();
                self::setData($experiencia[$key],$result[$key]);
            }
            return $experiencia;
        }

        public function insert(int $id_usuario,string $titulo,string $descr):int
        {
            $titulo = filter_var($titulo, FILTER_SANITIZE_STRING);
            $descr = filter_var($descr, FILTER_SANITIZE_STRING);
            $sql = new Sql();
            $results = $sql->query("INSERT INTO tb_experiencias(id_usuario, des_titulo, des_descricao) VALUES(:ID_USUARIO, :TITULO, :DESCR)", array(
                ':ID_USUARIO'=>$id_usuario,
                ':TITULO'=>$titulo,
                ':DESCR'=>$descr
            ));
            $result = $sql->select("SELECT LAST_INSERT_ID()");
            return $result[0]['LAST_INSERT_ID()'];
        }
        
        public function update(array $values)
        {
            $titulo = filter_var($values['des_titulo'], FILTER_SANITIZE_STRING);
            $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $sql = new Sql();
            $sql->query("UPDATE tb_experiencias SET id_usuario = :ID_USUARIO, des_titulo = :TITULO, des_descricao = :DESCR WHERE id_experiencia = :ID", array(
                ':ID_USUARIO'=>$values['id_usuario'],
                ':TITULO'=>$titulo,
                ':DESCR'=>$descr,
                ':ID'=>$values['id_experiencia']
            ));
        }
    
        public function delete(int $id)
        {
            $sql = new Sql();
            $sql->query("DELETE FROM tb_experiencias WHERE id_experiencia = :ID", array(
                ":ID"=>$id
            ));            
        }

        public function setData(ObjExperiencia $experiencia,array $data)
        {
            $experiencia->setIdExperiencia($data['id_experiencia']);
            $experiencia->setIdUsuarioExperiencia($data['id_usuario']);
            $experiencia->setTituloExperiencia($data['des_titulo']);
            $experiencia->setDescricaoExperiencia($data['des_descricao']);
        }
        
    }