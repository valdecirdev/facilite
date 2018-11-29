<?php

    namespace Controller;

    use Models\Formacao;
    use Core\Controller;

    class FormacaoController extends Controller
    {
        public function insert(int $id_usuario,string $titulo,string $descr):int
        {
            $titulo = filter_var($titulo, FILTER_SANITIZE_STRING);
            $descr = filter_var($descr, FILTER_SANITIZE_STRING);

            $formacao = new Formacao();
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

            Formacao::where('id_formacao', $id)
                ->update(['des_titulo' => $titulo, 'des_descricao' => $descr]);
        }

        public function delete(int $id): void
        {
            Formacao::where('id_formacao', '=', $id)->delete();
        }

        
    }