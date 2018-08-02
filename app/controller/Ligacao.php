<?php

namespace controller;

use model\LigacaoModel;
use model\object\ObjLigacao;
    
    class Ligacao
    {

        public function loadById(int $id_usuario, int $id_contato)
        {
            $ligacaoes = LigacaoModel::where([
                ['id_usuario', '=', $id_usuario],
                ['id_contato', '=', $id_contato]
            ])->get();
            $ligacaoes = $this->setData($ligacaoes);
            return $ligacaoes;
        }

        public function loadByUser(int $id, int $limite)
        {
            $ligacoes = LigacaoModel::where('id_usuario', '=', $id)->limit($limite)->get();
            $ligacoes = $this->setData($ligacoes);
            return $ligacoes;
        }

        public function add_ligacao(int $id_usuario,int $id_contato)
        {
            $ligacao = new LigacaoModel;
            $ligacao->id_usuario = $id_usuario;
            $ligacao->id_contato = $id_contato;
            $ligacao->save();
        }

        public function rem_ligacao(int $id_usuario, int $id_contato)
        {
            LigacaoModel::where([
                ['id_usuario', '=', $id_usuario],
                ['id_contato', '=', $id_contato],
            ])->delete();
        }

        public function setData($info)
        {
            $ligacoes = array();
            $cont = 0;
            foreach ($info as $data) {
                $ligacoes[$cont] = new ObjLigacao();
                $ligacoes[$cont]->setIdLigacao($data['id_ligacao']);
                $ligacoes[$cont]->setIdUsuarioLigacao($data['id_usuario']);
                $ligacoes[$cont]->setIdContatoLigacao($data['id_contato']);
                $ligacoes[$cont]->setDtLigacao($data['dt_ligacao']);
                $cont++;
            }
            return $ligacoes;
        }
    
    }

