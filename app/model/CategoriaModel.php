<?php

namespace model;

use model\dao\Sql;
use model\object\ObjCategoria;

    class CategoriaModel
    {

        public function loadByID($id):ObjCategoria
        {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_categorias WHERE id_categoria = :ID", array(
                ":ID"=>$id
            ));
            $categoria =  new ObjCategoria();
            if (count($result)>0) {
                self::setData($categoria,$result[0]);
            }
            return $categoria;
        }

        public function loadAll():array
        {
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_categorias");
            
            $categoria =  array();
            foreach ($result as $key => $value) {
                $categoria[$key] =  new ObjCategoria();
                self::setData($categoria[$key],$result[$key]);
            }
            return $categoria;  
        }

        public function setData(ObjCategoria $categoria,array $data)
        {
            $categoria->setIdCategoria($data['id_categoria']);
            $categoria->setDescricaoCategoria($data['des_descricao']);
            $categoria->setIconeCategoria($data['des_icone']);
        }

        
    }