<?php

namespace controller;

use model\ExperienciaModel;
    
    class Experiencia
    {

        public function loadByID(int $id)
        {
            $experiencia = new ExperienciaModel();
            return $experiencia->loadByID($id);
        }

        public function loadByUser(int $id):array
        {
            $experiencia = new ExperienciaModel();
            return $experiencia->loadByUser($id);
        }

        public function insert(int $id_usuario,string $titulo,string $descr):int
        {
            $experiencia = new ExperienciaModel();
            return $experiencia->insert($id_usuario, $titulo, $descr);
        }
        
        public function update(array $values)
        {
            $experiencia = new ExperienciaModel();
            $experiencia->update($values);     
        }
    
        public function delete(int $id)
        {
            $experiencia = new ExperienciaModel();
            $experiencia->delete($id);         
        }
        
    }