<?php

    namespace controller;

    use model\FormacaoModel;
    use model\object\ObjFormacao;

    class Formacao
    {

        public function loadByID(int $id)
        {
            $formacoes = FormacaoModel::where('id_formacao', '=', $id)->get();
            $formacao = $this->setData($formacoes);
            return $formacao[0];
        }

        public function loadByUser(int $id)
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
            //$result = $sql->select("SELECT LAST_INSERT_ID()");
            //return $result[0]['LAST_INSERT_ID()'];
        }

        public function update(array $values)
        {
            $titulo = filter_var($values['des_titulo'], FILTER_SANITIZE_STRING);
            $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $id = $values['id_formacao'];

            FormacaoModel::where('id_formacao', $id)
                ->update(['des_titulo' => $titulo, 'des_descricao' => $descr]);
        }

        public function delete(int $id)
        {
            FormacaoModel::where('id_formacao', '=', $id)->delete();
        }

        public function setData($infos)
        {
            $formacao = array();
            $cont = 0;
            foreach ($infos as $data) {
                $formacao[$cont] = new ObjFormacao();
                $formacao[$cont]->setIdFormacao($data['id_formacao']);
                $formacao[$cont]->setIdUsuarioFormacao($data['id_usuario']);
                $formacao[$cont]->setTituloFormacao($data['des_titulo']);
                $formacao[$cont]->setDescricaoFormacao($data['des_descricao']);
                $cont++;
            }
            return $formacao;
        }
        
    }