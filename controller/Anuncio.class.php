<?php
    
    class Anuncio
    {

        public function loadByID (int $id):ObjAnuncio
        {
            $anuncioModel = new AnuncioModel();
            return $anuncioModel->loadByID($id);
        }

        public function loadByUser (int $id):array
        {
            $anuncioModel = new AnuncioModel();
            return $anuncioModel->loadByUser($id);
        }

        public function insert (array $values)
        {
            $anuncioModel = new AnuncioModel();
            return $anuncioModel->insert($values);
        }

        public function update (array $values)
        {
            $anuncioModel = new AnuncioModel();
            $anuncioModel->update($values);
        }

        public function delete (int $id)
        {
            $anuncioModel = new AnuncioModel();
            $anuncioModel->delete($id);
        }
        
    }