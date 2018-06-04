<?php
    require_once('../view/config.php');

    class Categoria {

        public function loadByID(int $id):CategoriaModel{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_categorias WHERE id_categoria = :ID", array(
                ":ID"=>$id
            ));
            $categoria =  new CategoriaModel();
            if(count($result)>0){
                self::setData($categoria,$result[0]);
            }
            return $categoria;
        }

        public function loadAll():array{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_categorias");
            
            $categoria =  array();
            foreach ($result as $key => $value) {
                $categoria[$key] =  new CategoriaModel();
                self::setData($categoria[$key],$result[$key]);
            }
            return $categoria;  
        }

        public function setData(CategoriaModel $categoria,array $data){
            $categoria->setIdCategoria($data['id_categoria']);
            $categoria->setDescricaoCategoria($data['des_descricao']);
            $categoria->setIconeCategoria($data['des_icone']);
        }

        
    }