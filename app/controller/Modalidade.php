<?php

    namespace controller;

    use model\ModalidadeModel;

    class Modalidade
    {

        public function loadAll(): array
        {
            $modalidades = ModalidadeModel::all();
            $modalidade = $this->setData($modalidades);
            return $modalidade;
        }

        public function loadByID(int $id): ModalidadeModel
        {
            $modalidades = ModalidadeModel::where('id_modalidade', '=', $id)->get();
            $modalidade = $this->setData($modalidades);
            return $modalidade[0];
        }

        public function setData($infos): array
        {
            $modal = array();
            $cont = 0;
            foreach ($infos as $data) {
                $modal[$cont] = new ModalidadeModel();
                $modal[$cont]->setAttribute('id_modalidade', $data['id_modalidade']);
                $modal[$cont]->setAttribute('des_descricao', $data['des_descricao']);
                $cont++;
            }
            return $modal;
        }
        
    }