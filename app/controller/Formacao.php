<?php

    namespace controller;

    use model\FormacaoModel;

    class Formacao
    {

        public function loadByID(int $id): FormacaoModel
        {
            $formacoes = FormacaoModel::where('id_formacao', '=', $id)->get();
            $formacao = $this->setData($formacoes);
            return $formacao[0];
        }

        public function loadByUser(int $id): array
        {
            $formacoes = FormacaoModel::where('id_usuario', '=', $id)->orderBy('id_formacao','desc')->get();
            $formacao = $this->setData($formacoes);
            return $formacao;
        }

        public function insert(int $id_usuario,string $titulo,string $descr):int
        {
            $titulo = filter_var($titulo, FILTER_SANITIZE_STRING);
            $descr = filter_var($descr, FILTER_SANITIZE_STRING);

            $formacao = new FormacaoModel();
            $formacao->id_usuario = $id_usuario;
            $formacao->des_titulo = $titulo;
            $formacao->des_descricao = $descr;
            $formacao->save();
            return $formacao->id;
        }

        public function update(array $values)
        {
            $titulo = filter_var($values['des_titulo'], FILTER_SANITIZE_STRING);
            $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $id = $values['id_formacao'];

            FormacaoModel::where('id_formacao', $id)
                ->update(['des_titulo' => $titulo, 'des_descricao' => $descr]);
        }

        public function delete(int $id): void
        {
            FormacaoModel::where('id_formacao', '=', $id)->delete();
        }

        public function setData($infos): array
        {
            $formacao = array();
            foreach ($infos as $key => $data) {
                $formacao[$key] = new FormacaoModel();
                $formacao[$key]->setAttribute('id_formacao', $data['id_formacao']);
                $formacao[$key]->setAttribute('id_usuario', $data['id_usuario']);
                $formacao[$key]->setAttribute('des_titulo', $data['des_titulo']);
                $formacao[$key]->setAttribute('des_descricao', $data['des_descricao']);
            }
            return $formacao;
        }
        
    }