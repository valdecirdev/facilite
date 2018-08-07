<?php

    namespace controller;

    use model\Modalidade;

    class ModalidadeController
    {

        public function loadAll(): array
        {
            $modalidades = Modalidade::all();
            $modalidade = $this->setData($modalidades);
            return $modalidade;
        }

        public function loadByID(int $id): Modalidade
        {
            $modalidades = Modalidade::where('id_modalidade', '=', $id)->get();
            $modalidade = $this->setData($modalidades);
            return $modalidade[0];
        }

        public function setData($infos): array
        {
            $modal = array();
            $cont = 0;
            foreach ($infos as $data) {
                $modal[$cont] = new Modalidade();
                $modal[$cont]->setAttribute('id_modalidade', $data['id_modalidade']);
                $modal[$cont]->setAttribute('des_descricao', $data['des_descricao']);
                $cont++;
            }
            return $modal;
        }
        
    }