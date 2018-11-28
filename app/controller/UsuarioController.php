<?php

    namespace controller;

    use model\{Cidade, Confirmacao, Estado, Pais, Usuario};
    use PHPMailer\PHPMailer\PHPMailer;

    class UsuarioController
    {

        //---------------------------------------------------------------------
        //  STATICS
        //---------------------------------------------------------------------
        public static function logout()
        {
            session_start();
            session_destroy();
        }

        public static function login( array $loginInfos = array() ): bool
        {
            $result = Usuario::where('des_email', $loginInfos['des_email'])
                ->select('id_usuario', 'des_email', 'des_senha', 'des_slug', 'des_sexo')->get();
            if (( !isset($result[0])) || (!password_verify($loginInfos['des_senha'], $result[0]['des_senha']))) {
                return FALSE;
            }
            session_start();
            session_regenerate_id();
            $_SESSION = [
                'id'   => $result[0]['id_usuario'], 
                'nome' => $result[0]['des_nome'], 
                'slug' => $result[0]['des_slug'],
                'sexo' => $result[0]['des_sexo'],
            ];
            return TRUE;
        }

        public static function register( array $registerInfos = array() ): bool
        {
            $usuarioController = new UsuarioController();
            $email = filter_var($registerInfos['des_email'], FILTER_SANITIZE_EMAIL);
            $slug = $usuarioController->slugGenerator($registerInfos['des_nome']);
            $tmpNome = explode(' ', $registerInfos['des_nome']);
            $nomeExibicao = $tmpNome[0].' '.$tmpNome[count($tmpNome)-1];

            if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || ($usuarioController->emailExists($email))) {
                return FALSE;
            }

            $usuario = new Usuario([
                'id_plano'   => '1',
                'des_email'  => strtolower($email),
                'des_slug'   => strtolower($slug),
                'des_senha'  => password_hash($registerInfos['des_senha'], PASSWORD_DEFAULT),
                'des_nome'   => mb_convert_case($registerInfos['des_nome'], MB_CASE_TITLE, 'UTF-8'),
                'des_nome_exibicao' => $nomeExibicao,
                'des_sexo'   => $registerInfos['des_sexo'],
                'dt_nasc'    => $registerInfos['dt_nasc'],
                'des_status' => "Ativo",
            ]);
            $usuario->save();
            
            $loginInfos = ['des_email' => $registerInfos['des_email'], 'des_senha' => $registerInfos['des_senha']];
            self::login($loginInfos);
            
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

        //---------------------------------------------------------------------
        //  AUX
        //---------------------------------------------------------------------
        public function slugGenerator(string $fullName): string
        {
            $user = new UsuarioController();
            $fullName = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $fullName ) );
            $fullName = explode(' ', $fullName);
            $cont = null; $lastName = "";
            if (count($fullName) > 1) $lastName = $fullName[count($fullName)-1];

            do {
                $slug = $fullName[0].$lastName.$cont;
                $cont++;
            } while ($user->slugExists($slug));
            return $slug;
        }

        public function slugExists(string $slug): bool
        {
            return Usuario::where('des_slug', $slug)->exists();
        }

        public function emailExists(string $email)
        {
            return Usuario::where('des_email', $email)->exists();
        }


        //---------------------------------------------------------------------
        //  LOADS
        //---------------------------------------------------------------------
        public function loadBySlug(string $slug, array $campos = ['*'])
        {
            $usuario = Usuario::where('des_slug', $slug)->select($campos)->get();
            if (count($usuario)==0) {
                return NULL;
            }
            $usuario = $this->setInfosUsuario($usuario);
            return $usuario;
        }

        public function loadById(int $id, array $campos = ['*'])
        {
            $usuario = Usuario::where('id_usuario', $id)->select($campos)->get();
            if (count($usuario)==0) {
                return NULL;
            }
            $usuario = $this->setInfosUsuario($usuario);
            return $usuario;
        }

        public function loadByEmail(string $email, array $campos = ['*'])
        {
            $usuario = Usuario::where('des_email', $email)->select($campos)->get();
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

        public function loadCity()
        {
            $result = Cidade::all();
            if (count($result)==0) {
                return NULL;
            }
            return $result;
        }

        public function loadCityById(int $id)
        {
            $result = Cidade::where('id_cidade', $id)->get();
            if (count($result)==0) {
                return NULL;
            }
            return $result[0];
        }

        //---------------------------------------------------------------------
        //  UPDATES
        //---------------------------------------------------------------------
        public function email_update(string $email,int $id_usuario): bool
        {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || ($this->emailExists($email))) {
                return FALSE;
            }
            Usuario::where('id_usuario', $id_usuario)->update(['des_email' => $email]);
            return TRUE;
        }

        public function gen_update($campo, $valor, $id_usuario): bool
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
                    $valor = $this->loadCityByName($valor);
                    break;
                case 'des_slug':
                    $valor = str_replace(' ', '', $valor);
                    $valor = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $valor ) );
                    $valor = filter_var($valor, FILTER_SANITIZE_STRING);
                    if ($this->slugExists($valor)) {
                        return FALSE;
                    }
                    break;
            }
            Usuario::where('id_usuario', $id_usuario)->update([$campo => $valor]);
            return TRUE;
        }

        public function cep_update(string $cep, string $cidade, int $id): int
        {
            $cidade = UsuarioController::loadCityByName($cidade);
            Usuario::where('id_usuario', $id)->update(['des_cep' => $cep]);
            Usuario::where('id_usuario', $id)->update(['id_cidade' => $cidade[0]['id_cidade']]);
            return $id;
        }

        public function update_image($usuario, $files)
        {
            if ((!isset($files['usrFoto'])) || (is_null($files['usrFoto']))) {
                $foto = $usuario->des_foto;
                return $foto;
            }
            $foto = $usuario->des_foto;
            $diretorio = dirname(__DIR__).DS.'..'.DS.'public'.DS.'img'.DS.'profile'.DS;
            if (!is_dir($diretorio)) {
                mkdir($diretorio);
            }
            if (($foto != 'default.jpg') && (file_exists($diretorio . $foto))) {
                unlink($diretorio . $foto);
            }
            $foto = md5(time()).'.jpg';

            move_uploaded_file($files['usrFoto']['tmp_name'], $diretorio.$foto);
            $this->resize_image($diretorio.$foto);

            Usuario::where('id_usuario', $usuario->id_usuario)->update(['des_foto' => $foto]);
            return $foto;
        }



        //---------------------------------------------------------------------
        //  TOOLS
        //---------------------------------------------------------------------
        public function delete(int $id_usuario): void
        {
            self::logout();
            $result = Usuario::where('id_usuario', '=', $id_usuario)->select('des_foto')->get();
            $foto = $result[0]['des_foto'];
            if(($foto != 'default.jpg') && (file_exists(__DIR__.DS.'..'.DS.'..'.DS.'public'.DS.'img'.DS.'profile'.DS.$foto))) {
                unlink(__DIR__ . DS . '..' . DS . '..' . DS . 'public' . DS . 'img' . DS . 'profile' . DS . $foto);
            }
            Usuario::where('id_usuario', '=', $id_usuario)->delete();
        }

        public function resize_image(string $caminho_imagem): void
        {
            // Retorna o identificador da imagem
            $imagem = imagecreatefromjpeg($caminho_imagem);
            // Cria duas variáveis com a largura e altura da imagem
            list( $largura, $altura ) = getimagesize( $caminho_imagem );

            // Nova largura e altura
            $nova_largura = 150; //* $proporcao;
            $nova_altura = 150;// * $proporcao;

            // Cria uma nova imagem em branco
            $nova_imagem = imagecreatetruecolor( $nova_largura, $nova_altura );

            // Copia a imagem para a nova imagem com o novo tamanho
            imagecopyresampled(
                $nova_imagem, // Nova imagem
                $imagem, // Imagem original
                0, // Coordenada X da nova imagem
                0, // Coordenada Y da nova imagem
                0, // Coordenada X da imagem
                0, // Coordenada Y da imagem
                $nova_largura, // Nova largura
                $nova_altura, // Nova altura
                $largura, // Largura original
                $altura // Altura original
            );

            // Cria a imagem
            imagejpeg( $nova_imagem, $caminho_imagem, 100 );

            // Remove as imagens temporárias
            imagedestroy($imagem);
            imagedestroy($nova_imagem);
        }



        public function mailer($destinatario, $nome, $hash): void
        {
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->SMTPDebug = 2;
            $mail->Host = 'smtp.umbler.com';
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "noreply@faciliteserv.com";
            $mail->Password = "faciliteservicos";
            $mail->setFrom('noreply@faciliteserv.com', 'Facilite Servicos');
            $mail->addAddress($destinatario, $nome);
            $mail->Subject = 'Confirme seu email!';
            $mail->isHTML(true);
            $mail->Body    = 'Bem vindo '.$nome.'! <br> Confirme seu endereço de email através do link abaixo. <br> <a href="http://faciliteserv.com/confirm?hash='.$hash.'">Confirme seu email</a>';
            $mail->AltBody = 'This is the HTML message body';

            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        }

        //---------------------------------------------------------------------
        //  DATASET
        //---------------------------------------------------------------------
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
