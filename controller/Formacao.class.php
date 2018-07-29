<?php

namespace controller;

use model\FormacaoModel;
    
    class Formacao
    {

        public function loadByID(int $id)
        {
            $formacao = new FormacaoModel();
            return $formacao->loadByID($id);
        }

        public function loadByUser(int $id):array
        {
            $formacao = new FormacaoModel();
            return $formacao->loadByUser($id);
        }

        public function insert(int $id_usuario,string $titulo,string $descr):int
        {
            $formacao = new FormacaoModel();
            return $formacao->insert($id_usuario, $titulo, $descr);
        }
        
        public function update(array $values)
        {
            $formacao = new FormacaoModel();
            $formacao->update($values); 
        }
    
        public function delete(int $id)
        {
            $formacao = new FormacaoModel();
            $formacao->delete($id);       
        }
        
    }