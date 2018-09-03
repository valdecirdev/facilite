<?php

    namespace controller;

    use model\Cidade;
    use model\Confirmacao;
    use model\Estado;
    use model\Pais;
    use model\Usuario;
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

        public static function login(array $values = array()): bool
        {
            $result = Usuario::where('des_email', $values['login_des_email'])
                ->select('id_usuario', 'des_email', 'des_senha', 'des_slug', 'des_sexo')->get();
            if (count($result)>0) {
                if (password_verify($values['des_senha'], $result[0]['des_senha'])) {
                    session_start();
                    session_regenerate_id();
                    $_SESSION['id']   = $result[0]['id_usuario'];
                    $_SESSION['nome'] = $result[0]['des_nome'];
                    $_SESSION['slug'] = $result[0]['des_slug'];
                    $_SESSION['sexo'] = $result[0]['des_sexo'];
                    return TRUE;
                }
            }
            return FALSE;
        }

        public static function register(array $values = array())
        {
            $user = new UsuarioController();
            $fullName = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $_POST['des_nome'] ) );
            $fullName = explode(' ', $fullName);
            $cont = null; $lastName = "";
            if (count($fullName) > 1) $lastName = $fullName[count($fullName)-1];

            do {
                $slug = $fullName[0].$lastName.$cont;
                $cont++;
            } while ($user->slugExists($slug));
            $usuario = new Usuario();
            $usuario->setAttribute('id_plano', 1);
            $usuario->setAttribute('des_email', strtolower($values['des_email']));
            $usuario->setAttribute('des_slug', strtolower($slug));
            $usuario->setAttribute('des_senha', password_hash($values['des_senha'], PASSWORD_DEFAULT));
            $usuario->setAttribute('des_nome', mb_convert_case($values['des_nome'], MB_CASE_TITLE, 'UTF-8'));
            $usuario->setAttribute('des_sexo', $values['des_sexo']);
            $usuario->setAttribute('dt_nasc', $_POST['dt_nasc']);
            $usuario->setAttribute('des_status', "Pendente");
            if (!$user->emailExists($values['des_email'])) {
                $user->insert($usuario);
                $values = array(
                    'login_des_email'=>$values['des_email'],
                    'des_senha'=>$values['des_senha']
                );
                self::login($values);

                $hash = md5(date("Y/m/d H:i:s"));
                $confirm = new Confirmacao();
                $confirm->setAttribute('id_usuario', $_SESSION['id']);
                $confirm->setAttribute('des_hash', $hash);
                $confirmacao = new ConfirmacaoController();
                $confirmacao->insert($confirm);
                $user->mailer($_POST['des_email'], $_POST['des_nome'], $hash);
                return TRUE;
            }
            return FALSE;
        }

        //---------------------------------------------------------------------
        //  AUX
        //---------------------------------------------------------------------
        public function slugExists(string $slug)
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
        public function loadBySlug(string $slug)
        {
            $users = Usuario::where('des_slug', $slug)->get();
            $usuario = $this->setInfosUsuario($users);
            if (is_null($usuario) || count($usuario)==0) {
                return NULL;
            }
            return $usuario[0];
        }

        public function loadById(int $id)
        {
            $users = Usuario::where('id_usuario', $id)->get();
            $usuario = $this->setInfosUsuario($users);
            if (is_null($usuario) || count($usuario)==0) {
                return NULL;
            }
            return $usuario[0];
        }

        public function loadByEmail(string $email)
        {
            $users = Usuario::where('des_email', $email)->get();
            $usuario = $this->setInfosUsuario($users);
            if (is_null($usuario) || count($usuario)==0) {
                return NULL;
            }
            return $usuario[0];
        }

        public static function loadCityByName(string $nome)
        {
            $result = Cidade::where('des_nome', $nome)->get();
            if (is_null($result) || count($result)==0) {
                return NULL;
            }
            return $result;
        }

        public function loadCity()
        {
            $result = Cidade::all();
            if (is_null($result) || count($result)==0) {
                return NULL;
            }
            return $result;
        }

        public function loadCityById(int $id)
        {
            $result = Cidade::where('id_cidade', $id)->get();
            if (is_null($result) || count($result)==0) {
                return NULL;
            }
            return $result[0];
        }

        //---------------------------------------------------------------------
        //  INSERT
        //---------------------------------------------------------------------
        public function insert(Usuario $usuario): int
        {
            $user = new Usuario();
            $user->setAttribute('des_email', $usuario->getAttribute('des_email'));
            $user->setAttribute('des_slug' , $usuario->getAttribute('des_slug'));
            $user->setAttribute('des_senha', $usuario->getAttribute('des_senha'));
            $user->setAttribute('des_nome', $usuario->getAttribute('des_nome'));
            $nome = explode(' ', $usuario->getAttribute('des_nome'));
            $nomeExibicao = $nome[0].' '.$nome[count($nome)-1];
            $user->setAttribute('des_nome_exibicao', $nomeExibicao);
            $user->setAttribute('des_sexo', $usuario->getAttribute('des_sexo'));
            $user->setAttribute('dt_nasc', $usuario->getAttribute('dt_nasc'));
            $user->setAttribute('des_status', $usuario->getAttribute('des_status'));
            $user->save();
            return $user->id;
        }

        //---------------------------------------------------------------------
        //  UPDATES
        //---------------------------------------------------------------------
        public function email_update(string $email,int $id)
        {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if (!$this->emailExists($email)) {
                    Usuario::where('id_usuario', $id)
                        ->update(['des_email' => $email]);
                    return TRUE;
                }
            }
            return FALSE;
        }

        public function gen_update($campo, $valor, $id)
        {
            $valor = filter_var($valor, FILTER_SANITIZE_STRING);
            if($campo == 'des_nome'){
                $valor = mb_convert_case($valor, MB_CASE_TITLE, 'UTF-8');
            }else if($campo == 'des_senha'){
                $valor = password_hash($valor, PASSWORD_DEFAULT);
            }else if($campo == 'id_cidade'){
                $valor = $this->loadCityByName($valor);
            }
            Usuario::where('id_usuario', $id)->update([$campo => $valor]);
        }

        public function slug_update(string $slug, int $id)
        {
            $slug = str_replace(' ', '', $slug);
            $slug = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $slug ) );
            $slug = filter_var($slug, FILTER_SANITIZE_STRING);
            if (!$this->slugExists($slug)) {
                Usuario::where('id_usuario', $id)->update(['des_slug' => $slug]);
                return TRUE;
            }
            return FALSE;
        }

        public function cep_update(string $cep, string $cidade, int $id)
        {
            $cidade = UsuarioController::loadCityByName($cidade);
            Usuario::where('id_usuario', $id)->update(['des_cep' => $cep]);
            Usuario::where('id_usuario', $id)->update(['id_cidade' => $cidade[0]['id_cidade']]);
            return $id;
        }

        public function update_image(Usuario $usuario, array $files = array())
        {
            if ((isset($files['usrFoto']))&&(!is_null($files['usrFoto']))) {
                $foto = $usuario->getAttribute('des_foto');
                $diretorio = __DIR__.DS.'..'.DS.'..'.DS.'public'.DS.'img'.DS.'profile'.DS;
                if (!is_dir($diretorio)) {
                    mkdir($diretorio);
                }
                if ($foto != 'default.jpg') {
                    if(file_exists($diretorio . $foto)) {
                        unlink($diretorio . $foto);
                    }
                }
                $foto = md5(time()).'.jpg';

                move_uploaded_file($files['usrFoto']['tmp_name'], $diretorio.$foto);
                $this->resize_image($diretorio.$foto);

                $usuario->setAttribute('des_foto', $foto);
                Usuario::where('id_usuario', $usuario->getAttribute('id_usuario'))->update(['des_foto' => $foto]);
                return $foto;
            } else {
                $foto = $usuario->getAttribute('des_foto');
                return $foto;
            }
        }



        //---------------------------------------------------------------------
        //  TOOLS
        //---------------------------------------------------------------------
        public function delete(int $id): void
        {
            self::logout();
            $result = Usuario::where('id_usuario', '=', $id)->get();
            $foto = $result[0]['des_foto'];
            if($foto != 'default.jpg'){
                if(file_exists(__DIR__.DS.'..'.DS.'..'.DS.'public'.DS.'img'.DS.'profile'.DS.$foto)) {
                    unlink(__DIR__ . DS . '..' . DS . '..' . DS . 'public' . DS . 'img' . DS . 'profile' . DS . $foto);
                }
            }
            Usuario::where('id_usuario', '=', $id)->delete();
        }

        public function resize_image(string $caminho_imagem)
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

        public function mailer($destinatario, $nome, $hash)
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
        public function setInfosUsuario($infos): array
        {
            $usuario = array();
            foreach ($infos as $key => $data) {
                $usuario[$key] = new Usuario();

                $usuario[$key]->setAttribute('id_plano', $data['id_plano']);
                $usuario[$key]->setAttribute('des_nome', $data['des_nome']);
                $usuario[$key]->setAttribute('des_nome_exibicao', $data['des_nome_exibicao']);
                $usuario[$key]->setAttribute('des_slug', $data['des_slug']);
                $usuario[$key]->setAttribute('id_usuario', $data['id_usuario']);
                $usuario[$key]->setAttribute('des_email', $data['des_email']);

                $sexo = '';
                if ($data['des_sexo'] == 'M') {
                    $sexo = 'Masculino';
                } else if ($data['des_sexo'] == 'F') {
                    $sexo = 'Feminino';
                }

                $usuario[$key]->setAttribute('des_sexo', $sexo);
                $usuario[$key]->setAttribute('dt_nasc', $data['dt_nasc']);
                $usuario[$key]->setAttribute('des_apresentacao', $data['des_apresentacao']);
                $usuario[$key]->setAttribute('des_cpf', $data['des_cpf']);
                $usuario[$key]->setAttribute('des_foto', $data['des_foto']);
                $usuario[$key]->setAttribute('des_cep', $data['des_cep']);
                $usuario[$key]->setAttribute('id_cidade', $data['id_cidade']);
                $usuario[$key]->setAttribute('des_ocupacao', $data['des_ocupacao']);
                $usuario[$key]->setAttribute('des_telefone', $data['des_telefone']);
                $usuario[$key]->setAttribute('des_status', $data['des_status']);
                $usuario[$key]->setAttribute('dt_cadastro', $data['dt_cadastro']);
            }
            return $usuario;
        }
    }