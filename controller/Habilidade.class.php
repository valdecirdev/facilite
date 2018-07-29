<?php

namespace controller;

use model\HabilidadeModel;
    
    class Habilidade {

        public function loadAll()
        {
            $habilidade = new HabilidadeModel();
            return $habilidade->loadAll();
        }

        public function loadByID(int $id)
        {
            $habilidade = new HabilidadeModel();
            return $habilidade->loadByID($id);
        }

        public function loadByUser(int $id):array
        {
            $habilidade = new HabilidadeModel();
            return $habilidade->loadByUser($id);
        }

        public function insert(int $id_habilidade, int $id_usuario)
        {
            $habilidade = new HabilidadeModel();
            return $habilidade->insert($id_habilidade, $id_usuario);
        }
            
        public function delete(int $id_habilidade, int $id_usuario)
        {
            $habilidade = new HabilidadeModel();
            $habilidade->delete($id_habilidade, $id_usuario);  
        }
        
    }