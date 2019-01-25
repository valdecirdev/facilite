<?php

    namespace Controller;

    use Models\Categoria;
    use Core\Controller;

    class CategoriaController extends Controller
    {

        public function loadByID(int $id): Categoria
        {
            $categoria = Categoria::where('id_categoria', '=', $id)->get();
            $categoria = $this->setData($categoria);
            return $categoria[0];
        }

        public function loadAll(): array
        {
            $categorias = Categoria::all();
            $categorias = $this->setData($categorias);
            return $categorias;
        }

        public function loadLimit(int $limite): array
        {
            $categorias = Categoria::take($limite)->get();
            $categorias = $this->setData($categorias);
            return $categorias;
        }

        public function setData($infos): array
        {
            $categorias = array();
            foreach ($infos as $key => $data) {
                $categorias[$key] = new Categoria();
                $categorias[$key]->setAttribute('id_categoria', $data['id_categoria']);
                $categorias[$key]->setAttribute('des_descricao', $data['des_descricao']);
                $categorias[$key]->setAttribute('des_icone', $data['des_icone']);
            }
            return $categorias;
        }

    }