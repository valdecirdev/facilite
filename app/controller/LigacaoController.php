<?php

namespace controller;

use model\Ligacao;
    
    class LigacaoController
    {

        public function loadById(int $id_usuario, int $id_contato)
        {
            $ligacoes = Ligacao::where([
                ['id_usuario', '=', $id_usuario],
                ['id_contato', '=', $id_contato]
            ])->get();
            $ligacoes = $this->setData($ligacoes);
            return $ligacoes;
        }

        public function loadByUser(int $id, int $limite)
        {
            $ligacoes = Ligacao::where('id_usuario', '=', $id)->limit($limite)->get();
            $ligacoes = $this->setData($ligacoes);
            return $ligacoes;
        }

        public function add_ligacao(int $id_usuario,int $id_contato): void
        {
            $ligacao = new Ligacao;
            $ligacao->id_usuario = $id_usuario;
            $ligacao->id_contato = $id_contato;
            $ligacao->save();
        }

        public function rem_ligacao(int $id_usuario, int $id_contato): void
        {
            Ligacao::where([
                ['id_usuario', '=', $id_usuario],
                ['id_contato', '=', $id_contato],
            ])->delete();
        }

        public function setData($info): array
        {
            $ligacoes = array();
            foreach ($info as $key => $data) {
                $ligacoes[$key] = new Ligacao();
                $ligacoes[$key]->setAttribute('id_ligacao', $data['id_ligacao']);
                $ligacoes[$key]->setAttribute('id_usuario', $data['id_usuario']);
                $ligacoes[$key]->setAttribute('id_contato', $data['id_contato']);
                $ligacoes[$key]->setAttribute('dt_ligacao', $data['dt_ligacao']);
            }
            return $ligacoes;
        }
    
    }

