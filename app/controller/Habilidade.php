<?php

namespace controller;

use model\HabilidadeModel;
use model\HabilidadeUsuarioModel;

class Habilidade {

        public function loadAll()
        {
            $habilidades = HabilidadeUsuarioModel::all();
            $habilidade = $this->setData($habilidades);
            return $habilidade;
        }

        public function loadByID(int $id)
        {
            $habilidades = HabilidadeUsuarioModel::where('id_habilidade', '=', $id)->get();
            $habilidade = $this->setData($habilidades);
            return $habilidade[0];
        }

        public function loadByUser(int $id):array
        {
            $habilidades = HabilidadeUsuarioModel::where('id_usuario', '=', $id)->get();
            $habilidade = $this->setData($habilidades);
            return $habilidade;
        }

        public function insert(int $id_habilidade, int $id_usuario):int
        {
            $habilidades_usuarios = HabilidadeUsuarioModel::where('id_habilidade', '=', $id_habilidade)->where('id_usuario', '=', $id_usuario)->get();
            if ((count($habilidades_usuarios) == 0) || ($habilidades_usuarios == NULL)) {
                $experiencia = new HabilidadeUsuarioModel();
                $experiencia->id_usuario = $id_usuario;
                $experiencia->id_habilidade = $id_habilidade;
                $experiencia->save();
                return TRUE;
            }
            return FALSE;
        }

        public function delete(int $id_habilidade, int $id_usuario)
        {
            HabilidadeUsuarioModel::where('id_habilidade', '=', $id_habilidade)->where('id_usuario', '=', $id_usuario)->delete();
        }

        public function setData($infos)
        {
            $habilidade = array();
            foreach ($infos as $key => $data) {
                $habilidade[$key] = new HabilidadeModel();
                $habilidade[$key]->setAttribute('id_habilidade', $data['id_habilidade']);
                $habilidade[$key]->setAttribute('id_usuario', $data['id_usuario']);
                $habilidade[$key]->setAttribute('des_descricao', $data->habilidade->des_descricao);
            }
            return $habilidade;
        }
        
    }