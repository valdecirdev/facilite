<?php

    namespace Controller;

    use Models\Usuario;
    use Core\Controller;

    class LoginController extends Controller
    {

        public function index()
        {
            session_start();
            $pg_title = "Identifique-se - ";
            require BASEPATH."resources/view/login.php";
        }

        public static function logout()
        {
            session_start();
            session_destroy();
        }

        public static function login( array $login_infos = array() ): bool
        {
            $result = Usuario::where('des_email', $login_infos['des_email'])
                ->select('id_usuario', 'des_email', 'des_senha', 'des_slug', 'des_sexo')->get();
            if (( !isset($result[0])) || (!password_verify($login_infos['des_senha'], $result[0]['des_senha']))) {
                return FALSE;
            }
            session_start();
            session_regenerate_id();
            $_SESSION = [
                'logged' => TRUE,
                'id'     => $result[0]['id_usuario'], 
                'nome'   => $result[0]['des_nome'], 
                'slug'   => $result[0]['des_slug'],
                'sexo'   => $result[0]['des_sexo'],
            ];
            return TRUE;
        }

    }
