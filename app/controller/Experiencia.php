<?php

    namespace controller;

    use model\ExperienciaModel;

    class Experiencia
    {

        public function loadByID(int $id)
        {
            $experiencias = ExperienciaModel::where('id_categoria', '=', $id)->get();
            $experiencia = $this->setData($experiencias);
            return $experiencia[0];
        }

        public function loadByUser(int $id)
        {
            $experiencias = ExperienciaModel::where('id_usuario', '=', $id)->orderBy('id_experiencia','desc')->get();
            $experiencia = $this->setData($experiencias);
            return $experiencia;
        }

        public function insert(int $id_usuario,string $titulo,string $descr):int
        {
            $titulo = filter_var($titulo, FILTER_SANITIZE_STRING);
            $descr = filter_var($descr, FILTER_SANITIZE_STRING);

            $experiencia = new ExperienciaModel;
            $experiencia->id_usuario = $id_usuario;
            $experiencia->des_titulo = $titulo;
            $experiencia->des_descricao = $descr;
            $experiencia->save();
            return $experiencia->id;
        }

        public function update(array $values)
        {
            $titulo = filter_var($values['des_titulo'], FILTER_SANITIZE_STRING);
            $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $id = $values['id_experiencia'];

            ExperienciaModel::where('id_experiencia', $id)
                ->update(['des_titulo' => $titulo, 'des_descricao' => $descr]);
        }

        public function delete(int $id): void
        {
            ExperienciaModel::where('id_experiencia', '=', $id)->delete();
        }

        public function setData($infos): array
        {
            $experiencia = array();
            foreach ($infos as $key => $data) {
                $experiencia[$key] = new ExperienciaModel();
                $experiencia[$key]->setAttribute('id_experiencia', $data['id_experiencia']);
                $experiencia[$key]->setAttribute('id_usuario', $data['id_usuario']);
                $experiencia[$key]->setAttribute('des_titulo', $data['des_titulo']);
                $experiencia[$key]->setAttribute('des_descricao', $data['des_descricao']);
            }
            return $experiencia;
        }
        
    }