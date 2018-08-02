<?php

namespace controller;

use model\HabilidadeUsuarioModel;
use model\object\ObjHabilidade;

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
            $cont = 0;
            foreach ($infos as $data) {
                $habilidade[$cont] = new ObjHabilidade();
                $habilidade[$cont]->setIdHabilidade($data['id_habilidade']);
                $habilidade[$cont]->setIdUsuarioHabilidade($data['id_usuario']);
                $habilidade[$cont]->setDescricaoHabilidade($data->relatedHabilidade->des_descricao);
                $cont++;
            }
            return $habilidade;
        }
        
    }