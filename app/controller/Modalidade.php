<?php

namespace controller;

use model\ModalidadeModel;
use model\object\ObjModalidade;

class Modalidade
    {

        public function loadAll()
        {
            $modalidades = ModalidadeModel::all();
            $modalidade = $this->setData($modalidades);
            return $modalidade;
        }

        public function loadByID($id)
        {
            $modalidades = ModalidadeModel::where('id_modalidade', '=', $id)->get();
            $modalidade = $this->setData($modalidades);
            return $modalidade[0];
        }

        public function setData($infos)
        {
            $modalidade = array();
            $cont = 0;
            foreach ($infos as $data) {
                $modalidade[$cont] = new ObjModalidade();
                $modalidade[$cont]->setIdModalidade($data['id_modalidade']);
                $modalidade[$cont]->setDescricaoModalidade($data['des_descricao']);
                $cont++;
            }
            return $modalidade;
        }
        
    }