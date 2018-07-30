<?php

namespace vendor\controller;

use vendor\model\BuscaModel;
    
    class Busca
    {

        public function searchCount($search, $id){
            $busca = new BuscaModel();
            return $busca->searchCount($search, $id);
        }

        public function search(string $q, $id, $limit, $to){
            $busca = new BuscaModel();
            return $busca->search($q, $id, $limit, $to);
        }
        
    }