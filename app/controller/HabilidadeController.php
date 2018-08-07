<?php

namespace controller;

use model\Habilidade;
use model\HabilidadeUsuario;

class HabilidadeController {

        public function loadAll()
        {
            $habilidades = HabilidadeUsuario::all();
            $habilidade = $this->setData($habilidades);
            return $habilidade;
        }

        public function loadByID(int $id)
        {
            $habilidades = HabilidadeUsuario::where('id_habilidade', '=', $id)->get();
            $habilidade = $this->setData($habilidades);
            return $habilidade[0];
        }

        public function loadByUser(int $id):array
        {
            $habilidades = HabilidadeUsuario::where('id_usuario', '=', $id)->get();
            $habilidade = $this->setData($habilidades);
            return $habilidade;
        }

        public function insert(int $id_habilidade, int $id_usuario):int
        {
            $habilidades_usuarios = HabilidadeUsuario::where('id_habilidade', '=', $id_habilidade)->where('id_usuario', '=', $id_usuario)->get();
            if ((count($habilidades_usuarios) == 0) || ($habilidades_usuarios == NULL)) {
                $experiencia = new HabilidadeUsuario();
                $experiencia->id_usuario = $id_usuario;
                $experiencia->id_habilidade = $id_habilidade;
                $experiencia->save();
                return TRUE;
            }
            return FALSE;
        }

        public function delete(int $id_habilidade, int $id_usuario)
        {
            HabilidadeUsuario::where('id_habilidade', '=', $id_habilidade)->where('id_usuario', '=', $id_usuario)->delete();
        }

        public function setData($infos)
        {
            $habilidade = array();
            foreach ($infos as $key => $data) {
                $habilidade[$key] = new Habilidade();
                $habilidade[$key]->setAttribute('id_habilidade', $data['id_habilidade']);
                $habilidade[$key]->setAttribute('id_usuario', $data['id_usuario']);
                $habilidade[$key]->setAttribute('des_descricao', $data->habilidade->des_descricao);
            }
            return $habilidade;
        }
        
    }