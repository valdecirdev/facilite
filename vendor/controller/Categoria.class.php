<?php

namespace vendor\controller;

use vendor\model\Categoriamodel;
    
    class Categoria
    {

        public function loadByID($id)
        {
            $categoria = new CategoriaModel();
            return $categoria->loadByID($id);
        }

        public function loadAll():array
        {
            $categoria = new CategoriaModel();
            return $categoria->loadAll(); 
        }
        
    }