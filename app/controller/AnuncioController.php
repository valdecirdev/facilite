<?php

namespace Controller;

use Models\{Anuncio, Usuario};
use Core\Controller;

class AnuncioController extends Controller
{

    public function index($id)
    {
        session_start();

        $servico = Anuncio::where('id_anuncio', $id)->get()[0] ?? header('location:erro');
        $usuario = Usuario::where('id_usuario', $servico->id_usuario)->get()[0] ?? header('location:erro');
        $pg_title    = $servico->categoria->des_descricao.' - ';
        $description = $servico->des_descricao;

        $donoServico = false;
        if (isset($_SESSION['id']) && ($_SESSION['id'] == $usuario->id_usuario)) {
            $donoServico = true;
            $logged_user  = $usuario;
        } else {
            if(isset($_SESSION['id']) && !is_null($_SESSION['id'])){
                $logged_user = Usuario::where('id_usuario', $_SESSION['id'])->get()[0];
            }
        }
        
        require BASEPATH."resources/view/service.php";
    }

    public function insert (array $values): int
    {
        $values['des_descricao']  = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
        $values['des_preco']  = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
        $values['des_disponibilidade'] = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);

        $anuncio = new Anuncio();
        $anuncio->setAttribute('id_usuario', $values['id_usuario']);
        $anuncio->setAttribute('id_categoria', $values['id_categoria']);
        $anuncio->setAttribute('des_descricao', $values['des_descricao']);
        $anuncio->setAttribute('des_preco', $values['des_preco']);
        $anuncio->setAttribute('id_modalidade', $values['id_modalidade']);
        $anuncio->setAttribute('des_disponibilidade', $values['des_disponibilidade']);
        $anuncio->save();
        return $anuncio->id;
    }

    public function update (array $values): void
    {
        $values['des_descricao'] = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
        $values['des_preco'] = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
        $values['des_disponibilidade'] = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);
        Anuncio::where('id_anuncio', $values['id_anuncio'])->update(['id_categoria' => $values['id_categoria'], 'des_descricao' => $values['des_descricao'], 'des_preco' => $values['des_preco'], 'id_modalidade' => $values['id_modalidade'], 'des_disponibilidade' => $values['des_disponibilidade']]);
    }

    public function delete (int $id): void
    {
        Anuncio::where('id_anuncio', $id)->delete();
    }

}