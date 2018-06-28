<?php
    
    class Modalidade
    {

        public function loadAll():array
        {
            $modalidade = new ModalidadeModel();
            return $modalidade->loadAll();
        }

        public function loadByID ($id):ObjModalidade
        {
            $modalidade = new ModalidadeModel();
            return $modalidade->loadByID($id);
        }
        
    }