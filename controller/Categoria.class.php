<?php
    
    class Categoria
    {

        public function loadByID($id):ObjCategoria
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