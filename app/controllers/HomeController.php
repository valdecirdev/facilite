<?php

    namespace Controller;

    use Models\Usuario;
    use Core\Controller;

    class HomeController extends Controller
    {

        public static function index()
        {
            session_start();
            if(isset($_SESSION['logged'])){
                $logged_user = Usuario::where('id_usuario', $_SESSION['id'])->get()[0];
            }
            $pg_title = '';
            require BASEPATH."resources/view/index.php";
        }
    
    }