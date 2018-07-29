<?php

namespace controller;

use model\LigacaoModel;
    
    class Ligacao
    {

        public function loadById(int $id_usuario,int $id_contato)
        {
            $ligacao = new LigacaoModel();
            return $ligacao->loadById($id_usuario, $id_contato);
        }

        public function loadByUser(int $id,int $limite): array
        {
            $ligacao = new LigacaoModel();
            return $ligacao->loadByUser($id, $limite);
        }

        public function add_ligacao(int $id_usuario,int $id_contato)
        {
            $ligacao = new LigacaoModel();
            $ligacao->add_ligacao($id_usuario, $id_contato);
        }

        public function rem_ligacao(int $id_usuario,int $id_contato)
        {
            $ligacao = new LigacaoModel();
            $ligacao->rem_ligacao($id_usuario, $id_contato);
        }
    
    }










    
    
    







