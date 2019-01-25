<?php

namespace Controller;

use Models\{Habilidade, HabilidadeUsuario};
use Core\Controller;

class HabilidadeController extends Controller
{

        public function loadAll()
        {
            $habilidades = Habilidade::all();
            $habilidade = $this->setData($habilidades);
            return $habilidade;
        }

        public function insert(int $id_habilidade, int $id_usuario):int
        {
            $habilidades_usuarios = HabilidadeUsuario::where('id_habilidade', $id_habilidade)->where('id_usuario', $id_usuario)->get();
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
            HabilidadeUsuario::where('id_habilidade', $id_habilidade)->where('id_usuario', $id_usuario)->delete();
            return TRUE;
        }

        public function setData($infos)
        {
            $habilidade = array();
            foreach ($infos as $key => $data) {
                $habilidade[$key] = new Habilidade();
                $habilidade[$key]->setAttribute('id_habilidade', $data['id_habilidade']);
                $habilidade[$key]->setAttribute('des_descricao', $data['des_descricao']);
            }
            return $habilidade;
        }
        
    }