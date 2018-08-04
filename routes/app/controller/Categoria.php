<?php

    namespace controller;

    use model\CategoriaModel;
    use model\object\ObjCategoria;

    class Categoria
    {

        public function loadByID($id)
        {
            $categorias = CategoriaModel::where('id_categoria', '=', $id)->get();
            $categoria = $this->setData($categorias);
            return $categoria[0];
        }

        public function loadAll()
        {
            $categorias = CategoriaModel::all();
            $categoria = $this->setData($categorias);
            return $categoria;
        }

        public function setData($infos)
        {
            $categoria = array();
            $cont = 0;
            foreach ($infos as $data) {
                $categoria[$cont] = new ObjCategoria();
                $categoria[$cont]->setIdCategoria($data['id_categoria']);
                $categoria[$cont]->setDescricaoCategoria($data['des_descricao']);
                $categoria[$cont]->setIconeCategoria($data['des_icone']);
                $cont++;
            }
            return $categoria;
        }

    }