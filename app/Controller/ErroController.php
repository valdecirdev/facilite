<?php

namespace Controller;

use Models\Usuario;
use Core\Controller;

class ErroController extends Controller
{
    public function index()
    {
        session_start();
        if(isset($_SESSION['logged'])){
            $logged_user = Usuario::where('id_usuario', $_SESSION['id'])->get()[0];
        }
        $pg_title = 'Pagina Não Encontrada - ';
        require BASEPATH."resources/view/error.php";
    }
}