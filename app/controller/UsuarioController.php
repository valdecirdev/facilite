<?php

    namespace Controller;

    use Models\{Cidade, Confirmacao, Estado, Pais, Usuario};
    use Core\Controller;

    class UsuarioController extends Controller
    {

        public function loadById(int $id, array $campos = ['*'])
        {
            $usuario = Usuario::where('id_usuario', $id)->select($campos)->get();
            if (count($usuario)==0) {
                return NULL;
            }
            $usuario = $this->setInfosUsuario($usuario);
            return $usuario;
        }

        public static function loadCityByName(string $nome)
        {
            $result = Cidade::where('des_nome', $nome)->get();
            if (count($result)==0) {
                return NULL;
            }
            return $result;
        }


        // public function mailer($destinatario, $nome, $hash): void
        // {
        //     $mail = new PHPMailer();
        //     $mail->isSMTP();
        //     $mail->SMTPDebug = 2;
        //     $mail->Host = 'smtp.umbler.com';
        //     $mail->Port = 587;
        //     $mail->SMTPSecure = 'tls';
        //     $mail->SMTPAuth = true;
        //     $mail->Username = "noreply@faciliteserv.com";
        //     $mail->Password = "faciliteservicos";
        //     $mail->setFrom('noreply@faciliteserv.com', 'Facilite Servicos');
        //     $mail->addAddress($destinatario, $nome);
        //     $mail->Subject = 'Confirme seu email!';
        //     $mail->isHTML(true);
        //     $mail->Body    = 'Bem vindo '.$nome.'! <br> Confirme seu endereço de email através do link abaixo. <br> <a href="http://faciliteserv.com/confirm?hash='.$hash.'">Confirme seu email</a>';
        //     $mail->AltBody = 'This is the HTML message body';

        //     if (!$mail->send()) {
        //         echo "Mailer Error: " . $mail->ErrorInfo;
        //     }
        // }

        // // ---------------------------------------------------------------------
        // //  DATASET
        // // ---------------------------------------------------------------------
        public function setInfosUsuario($infos): Usuario
        {
            $sexo = '';
            if ($infos[0]['des_sexo'] == 'M') {
                $sexo = 'Masculino';
            } 
            if ($infos[0]['des_sexo'] == 'F') {
                $sexo = 'Feminino';
            }

            $usuario = new Usuario([
                'id_usuario'        => $infos[0]['id_usuario'],
                'id_plano'          => $infos[0]['id_plano'],
                'des_email'         => $infos[0]['des_email'],
                'des_slug'          => $infos[0]['des_slug'],
                'des_nome'          => $infos[0]['des_nome'],
                'des_nome_exibicao' => $infos[0]['des_nome_exibicao'],
                'dt_nasc'           => $infos[0]['dt_nasc'],
                'des_sexo'          => $sexo,
                'des_apresentacao'  => $infos[0]['des_apresentacao'],
                'des_cpf'           => $infos[0]['des_cpf'],
                'des_foto'          => $infos[0]['des_foto'],
                'des_cep'           => $infos[0]['des_cep'],
                'id_cidade'         => $infos[0]['id_cidade'],
                'des_ocupacao'      => $infos[0]['des_ocupacao'],
                'des_telefone'      => $infos[0]['des_telefone'],
                'des_status'        => $infos[0]['des_status'],
                'dt_cadastro'       => $infos[0]['dt_cadastro'],
            ]);
            return $usuario;
        }
    }
