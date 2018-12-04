<?php

    namespace Controller;

    use Models\Formacao;
    use Core\Controller;

    class FormacaoController extends Controller
    {
        public function insert(array $values):int
        {
            $titulo = filter_var($titulo, FILTER_SANITIZE_STRING);
            $descr = filter_var($descr, FILTER_SANITIZE_STRING);

            $formacao = new Formacao();
            $formacao->id_usuario       = $values['id_usuario'];
            $formacao->des_titulo       = $values['titulo'];
            $formacao->des_descricao    = $values['descr'];
            $formacao->des_de           = $values['desde'];
            $formacao->des_ate          = $values['ate'];
            $formacao->save();
            return $formacao->id;
        }

        public function update(array $values)
        {
            $titulo = filter_var($values['des_titulo'], FILTER_SANITIZE_STRING);
            $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $id = $values['id_formacao'];
            $desde = $values['desde'];
            $ate = $values['ate'];

            Formacao::where('id_formacao', $id)
                ->update(['des_titulo' => $titulo, 'des_descricao' => $descr, 'des_de'=>$desde, 'des_ate'=>$ate]);
        }

        public function delete(int $id): void
        {
            Formacao::where('id_formacao', '=', $id)->delete();
        }

        
    }