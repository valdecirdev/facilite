<?php

    namespace controller;

    use model\CategoriaModel;

    class Categoria
    {

        public function loadByID($id): CategoriaModel
        {
            $categorias = CategoriaModel::where('id_categoria', '=', $id)->get();
            $categoria = $this->setData($categorias);
            return $categoria[0];
        }

        public function loadAll(): array
        {
            $categorias = CategoriaModel::all();
            $categoria = $this->setData($categorias);
            return $categoria;
        }

        public function setData($infos): array
        {
            $categoria = array();
            foreach ($infos as $key => $data) {
                $categoria[$key] = new CategoriaModel();
                $categoria[$key]->setAttribute('id_categoria', $data['id_categoria']);
                $categoria[$key]->setAttribute('des_descricao', $data['des_descricao']);
                $categoria[$key]->setAttribute('des_icone', $data['des_icone']);
            }
            return $categoria;
        }

    }