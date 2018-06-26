<?php
    
    class Busca
    {

        public function searchCount(string $q, $id){
            $busca = new BuscaModel();
            return $busca->searchCount($q, $id);
        }

        public function search(string $q, $id, $limit, $to){
            $busca = new BuscaModel();
            return $busca->search($q, $id, $limit, $to);
        }
        
    }