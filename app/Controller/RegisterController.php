<?php

    namespace Controller;

    use Models\Usuario;
    use Core\Controller;

    class RegisterController extends Controller
    {

        public function index()
        {
            session_start();
            $pg_title = "Cadastre-se - ";
            require BASEPATH."resources/view/register.php";
        }

        public static function register( array $register_infos = array() ): bool
        {
            $usuario = new Usuario();
            $email = filter_var($register_infos['des_email'], FILTER_SANITIZE_EMAIL);
            if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || ($usuario->emailExists($email))) {
                return FALSE;
            }

            $slug = $usuario->slugGenerator($register_infos['des_nome']);
            $tmpNome = explode(' ', $register_infos['des_nome']);
            $nomeExibicao = $tmpNome[0].' '.$tmpNome[count($tmpNome)-1];

            $usuario = new Usuario([
                'id_plano'   => '1',
                'des_email'  => strtolower($email),
                'des_slug'   => strtolower($slug),
                'des_senha'  => password_hash($register_infos['des_senha'], PASSWORD_DEFAULT),
                'des_nome'   => mb_convert_case($register_infos['des_nome'], MB_CASE_TITLE, 'UTF-8'),
                'des_nome_exibicao' => $nomeExibicao,
                'des_sexo'   => $register_infos['des_sexo'],
                'dt_nasc'    => $register_infos['dt_nasc'],
                'des_status' => "Ativo",
            ]);
            $usuario->save();
            
            $login_infos = ['des_email' => $register_infos['des_email'], 'des_senha' => $register_infos['des_senha']];
            $login = new LoginController();
            $login->login($login_infos);
            
            // Código responsável pelo envio de email e confirmação de conta

            // $hash = md5(date("Y/m/d H:i:s"));
            // $confirmacao = new Confirmacao([
            //     'id_usuario' => $_SESSION['id'],
            //     'des_hash'   => $hash,
            // ]);
            // $confirmacaoController = new ConfirmacaoController();
            
            // $confirmacaoController->insert($confirmacao);
            // $usuarioController->mailer($email, $registerInfos['des_nome'], $hash);
            return TRUE;
        }

    }
