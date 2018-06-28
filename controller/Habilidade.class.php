<?php
    
    class Habilidade {

        public function loadAll()
        {
            $habilidade = new Habilidademodel();
            return $habilidade->loadAll();
        }

        public function loadByID(int $id):ObjHabilidade
        {
            $habilidade = new Habilidademodel();
            return $habilidade->loadByID($id);
        }

        public function loadByUser(int $id):array
        {
            $habilidade = new Habilidademodel();
            return $habilidade->loadByUser($id);
        }

        public function insert(int $id_habilidade, int $id_usuario)
        {
            $habilidade = new Habilidademodel();
            return $habilidade->insert($id_habilidade, $id_usuario);
        }
            
        public function delete(int $id_habilidade, int $id_usuario)
        {
            $habilidade = new Habilidademodel();
            $habilidade->delete($id_habilidade, $id_usuario);  
        }
        
    }