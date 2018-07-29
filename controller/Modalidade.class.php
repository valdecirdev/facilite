<?php

namespace controller;

use model\ModalidadeModel;
    
    class Modalidade
    {

        public function loadAll():array
        {
            $modalidade = new ModalidadeModel();
            return $modalidade->loadAll();
        }

        public function loadByID ($id)
        {
            $modalidade = new ModalidadeModel();
            return $modalidade->loadByID($id);
        }
        
    }