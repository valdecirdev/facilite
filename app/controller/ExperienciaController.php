<?php

    namespace Controller;

    use Models\Experiencia;
    use Core\Controller;

    class ExperienciaController extends Controller
    {

        public function insert(array $values):int
        {
            $titulo = filter_var($titulo, FILTER_SANITIZE_STRING);
            $descr = filter_var($descr, FILTER_SANITIZE_STRING);

            $experiencia = new Experiencia;
            $experiencia->id_usuario    = $values['id_usuario'];
            $experiencia->des_titulo    = $values['titulo'];
            $experiencia->des_descricao = $values['descr'];

            $experiencia->des_de = $values['desde'];
            $experiencia->des_ate = $values['ate'];
            $experiencia->save();
            return $experiencia->id;
        }

        public function update(array $values)
        {
            $titulo = filter_var($values['des_titulo'], FILTER_SANITIZE_STRING);
            $descr  = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
            $desde  = $values['desde'];
            $ate    = $values['ate'];
            $id     = $values['id_experiencia'];

            Experiencia::where('id_experiencia', $id)
                ->update(['des_titulo' => $titulo, 'des_descricao' => $descr, 'des_de' => $desde, 'des_ate' => $ate]);
        }

        public function delete(int $id): void
        {
            Experiencia::where('id_experiencia', '=', $id)->delete();
        }
        
    }