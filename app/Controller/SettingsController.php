<?php

    namespace Controller;

    use Models\{Usuario, Cidade};
    use Core\Controller;
    use Controller\Login;

    class SettingsController extends Controller
    {

        public function index()
        {
            session_start();
            if (!isset($_SESSION['logged'])){
                header('location: home');
            }
            $logged_user = Usuario::where('id_usuario', $_SESSION['id'])->get()[0];
            $pg_title = 'Configurações - ';
            require BASEPATH."resources/view/configs.php";
        }

        public function genUpdate($campo, $valor, $id_usuario): bool
        {
            $valor = filter_var($valor, FILTER_SANITIZE_STRING);
            switch ($campo) {
                case 'des_nome':
                    $valor = mb_convert_case($valor, MB_CASE_TITLE, 'UTF-8');
                    break;
                case 'des_senha':
                    $valor = password_hash($valor, PASSWORD_DEFAULT);
                    break;
                case 'id_cidade':
                    $result = Cidade::where('des_nome', $valor)->get();
                    break;
                case 'des_slug':
                    $valor = str_replace(' ', '', $valor);
                    $valor = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $valor ) );
                    $valor = filter_var($valor, FILTER_SANITIZE_STRING);
                    if (Usuario::slugExists($valor)) {
                        return FALSE;
                    }
                    break;
            }
            Usuario::where('id_usuario', $id_usuario)->update([$campo => $valor]);
            return TRUE;
        }

        public function emailUpdate(string $email,int $id_usuario): bool
        {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || (Usuario::emailExists($email))) {
                return FALSE;
            }
            Usuario::where('id_usuario', $id_usuario)->update(['des_email' => $email]);
            return TRUE;
        }

        public function cepUpdate(string $cep, string $cidade, int $id): int
        {
            $cidade = UsuarioController::loadCityByName($cidade);
            Usuario::where('id_usuario', $id)->update(['des_cep' => $cep]);
            Usuario::where('id_usuario', $id)->update(['id_cidade' => $cidade[0]['id_cidade']]);
            return $id;
        }

        public function delete(int $id_usuario): void
        {
            Login::logout();
            $result = Usuario::where('id_usuario', '=', $id_usuario)->select('des_foto')->get();
            $foto = $result[0]['des_foto'];
            if(($foto != 'default.jpg') && (file_exists(__DIR__.DS.'..'.DS.'..'.DS.'public'.DS.'img'.DS.'profile'.DS.$foto))) {
                unlink(__DIR__ . DS . '..' . DS . '..' . DS . 'public' . DS . 'img' . DS . 'profile' . DS . $foto);
            }
            Usuario::where('id_usuario', '=', $id_usuario)->delete();
        }
    
    }