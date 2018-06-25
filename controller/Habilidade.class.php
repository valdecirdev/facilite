<?php
    
    class Habilidade {

        public function loadAll()
        {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_habilidades");
            $habilidade = array();
            foreach ($result as $key => $value) {
                $habilidade[$key] =  new ObjHabilidade();
                $habilidade[$key]->setIdHabilidade($result[$key]['id_habilidade']);
                $habilidade[$key]->setDescricaoHabilidade($result[$key]['des_descricao']);
            }
            return $habilidade;
        }

        public function loadByID(int $id):ObjHabilidade
        {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_habilidades_usuario WHERE id_habilidade = :ID", array(
                ":ID"=>$id
            ));
            $habilidade =  new ObjHabilidade();
            if (count($result)>0) {
                self::setData($habilidade,$result[0]);
            }
            return $habilidade;
        }

        public function loadByUser(int $id):array
        {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_habilidades,tb_habilidades_usuarios WHERE tb_habilidades_usuarios.id_usuario = :ID AND tb_habilidades_usuarios.id_habilidade = tb_habilidades.id_habilidade ", array(
                ":ID"=>$id
            ));
            $habilidade = array();
            foreach ($result as $key => $value) {
                $habilidade[$key] = new ObjHabilidade();
                self::setData($habilidade[$key],$result[$key]);
            }
            return $habilidade;
        }

        public function insert(int $id_habilidade, int $id_usuario)
        {
            $sql = new Sql();
            $results = $sql->select("SELECT id_habilidade_usuario FROM tb_habilidades_usuarios WHERE (id_usuario = :IDU AND id_habilidade = :IDH)", array(
                ":IDU"=>$id_usuario,
                ":IDH"=>$id_habilidade
            ));
            if ((count($results) == 0)||($results == NULL)) {
                $results = $sql->select("INSERT INTO tb_habilidades_usuarios(id_usuario, id_habilidade) VALUES(:ID_USUARIO, :ID_HABILIDADE)", array(
                    ':ID_USUARIO'=>$id_usuario,
                    ':ID_HABILIDADE'=>$id_habilidade
                ));
                return TRUE;
            }
            return FALSE;
        }
            
        public function delete(int $id_habilidade, int $id_usuario)
        {
            $sql = new Sql();
            $sql->query("DELETE FROM tb_habilidades_usuarios WHERE (id_habilidade = :IDH AND id_usuario = :IDU)", array(
                ":IDH"=>$id_habilidade,
                ":IDU"=>$id_usuario
            ));     
        }

        public function setData(ObjHabilidade $habilidade, array $data)
        {
            $habilidade->setIdHabilidade($data['id_habilidade']);
            $habilidade->setIdUsuarioHabilidade($data['id_usuario']);
            $habilidade->setDescricaoHabilidade($data['des_descricao']);
        }

        
    }