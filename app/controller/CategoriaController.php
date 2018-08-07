<?php

    namespace controller;

    use model\Categoria;

    class CategoriaController
    {

        public function loadByID($id): Categoria
        {
            $categorias = Categoria::where('id_categoria', '=', $id)->get();
            $categoria = $this->setData($categorias);
            return $categoria[0];
        }

        public function loadAll(): array
        {
            $categorias = Categoria::all();
            $categoria = $this->setData($categorias);
            return $categoria;
        }

        public function setData($infos): array
        {
            $categoria = array();
            foreach ($infos as $key => $data) {
                $categoria[$key] = new Categoria();
                $categoria[$key]->setAttribute('id_categoria', $data['id_categoria']);
                $categoria[$key]->setAttribute('des_descricao', $data['des_descricao']);
                $categoria[$key]->setAttribute('des_icone', $data['des_icone']);
            }
            return $categoria;
        }

    }