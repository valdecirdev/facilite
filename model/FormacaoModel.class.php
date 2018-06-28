<?php
    
    class FormacaoModel
    {

        public function loadByID(int $id):ObjFormacao
        {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_formacoes WHERE id_formacao = :ID", array(
                ":ID"=>$id
            ));
            $formacao =  new ObjFormacao();
            if (count($result)>0) {
                self::setData($formacao,$result[0]);
            }
            return $formacao;
        }

        public function loadByUser(int $id):array
        {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_formacoes WHERE id_usuario = :ID ORDER BY id_formacao desc", array(
                ":ID"=>$id
            ));
            $formacao = array();
            foreach ($result as $key => $value) {
                $formacao[$key] = new ObjFormacao();
                self::setData($formacao[$key],$result[$key]);
            }
            return $formacao;
        }

        public function insert(int $id_usuario,string $titulo,string $descr):int
        {
            $titulo = filter_var($titulo, FILTER_SANITIZE_STRING);
            $descr = filter_var($descr, FILTER_SANITIZE_STRING);
            $sql = new Sql();
            $results = $sql->select("INSERT INTO tb_formacoes(id_usuario, des_titulo, des_descricao) VALUES(:ID_USUARIO, :TITULO, :DESCR)", array(
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
            $sql->query("UPDATE tb_formacoes SET id_usuario = :ID_USUARIO, des_titulo = :TITULO, des_descricao = :DESCR WHERE id_formacao = :ID", array(
                ':ID_USUARIO'=>$values['id_usuario'],
                ':TITULO'=>$titulo,
                ':DESCR'=>$descr,
                ':ID'=>$values['id_formacao']
            ));
        }
    
        public function delete(int $id)
        {
            $sql = new Sql();
            $sql->query("DELETE FROM tb_formacoes WHERE id_formacao = :ID", array(
                ":ID"=>$id
            ));            
        }

        public function setData(ObjFormacao $formacao,array $data)
        {
            $formacao->setIdFormacao($data['id_formacao']);
            $formacao->setIdUsuarioFormacao($data['id_usuario']);
            $formacao->setTituloFormacao($data['des_titulo']);
            $formacao->setDescricaoFormacao($data['des_descricao']);
        }
        
    }