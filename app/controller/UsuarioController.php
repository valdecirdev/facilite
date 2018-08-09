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

        public static function login(array $values = array())
        {
            $user = new UsuarioController();
            $result = $user->verifyUniqueEmail($values['login_des_email']);
            if (count($result)>0) {
                if (password_verify($values['des_senha'], $result[0]['des_senha'])) {
                    session_start();
                    session_regenerate_id();
                    $_SESSION['id'] = $result[0]['id_usuario'];
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
            if (count($fullName) > 1) {
                $lastName = $fullName[count($fullName)-1];
            }
            do {
                $slug = $fullName[0].$lastName.$cont;
                $cont++;
            } while (!$user->verifyUniqueSlug($slug));
            $usuario = new Usuario();
            $usuario->setAttribute('des_email', strtolower($values['des_email']));
            $usuario->setAttribute('des_slug', strtolower($slug));
            $usuario->setAttribute('des_senha', password_hash($values['des_senha'], PASSWORD_DEFAULT));
            $usuario->setAttribute('des_nome', mb_convert_case($values['des_nome'], MB_CASE_TITLE, 'UTF-8'));
            $usuario->setAttribute('des_sexo', $values['des_sexo']);
            $usuario->setAttribute('dt_nasc', $_POST['dt_nasc']);
            $usuario->setAttribute('des_status', "Pendente");
            if (count($user->verifyUniqueEmail($values['des_email']))==0) {
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
        public function verifyUniqueSlug(string $slug)
        {
            $result = Usuario::where('des_slug', '=' , $slug)->get();
            if (count($result)==0) {
                return TRUE;
            }
            return FALSE;
        }

        public function verifyUniqueEmail(string $email, int $id = NULL)
        {
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if (!is_null($id)) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $result = Usuario::where('des_email', '=' , $email)->where('id_usuario', '=', $id)->get();
                    return $result;
                }
            } else {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $result = Usuario::where('des_email', '=' , $email)->get();
                    return $result;
                }
            }
            return NULL;
        }


        //---------------------------------------------------------------------
        //  LOADS
        //---------------------------------------------------------------------
        public function loadBySlug(string $slug)
        {
            $users = Usuario::where('des_slug', '=', $slug)->get();
            $usuario = $this->setInfosUsuario($users);
            if (is_null($usuario) || count($usuario)==0) {
                return NULL;
            }
            return $usuario[0];
        }

        public function loadById(int $id)
        {
            $users = Usuario::where('id_usuario', '=', $id)->get();
            $usuario = $this->setInfosUsuario($users);
            if (is_null($usuario) || count($usuario)==0) {
                return NULL;
            }
            return $usuario[0];
        }

        public function loadByEmail(string $email)
        {
            $users = Usuario::where('des_email', '=', $email)->get();
            $usuario = $this->setInfosUsuario($users);
            if (is_null($usuario) || count($usuario)==0) {
                return NULL;
            }
            return $usuario[0];
        }

        public function loadCityByName(string $nome)
        {
            $result = Cidade::where('des_nome', '=', $nome)->get();
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
            $result = Cidade::where('id_cidade', '=', $id)->get();
            if (is_null($result) || count($result)==0) {
                return NULL;
            }
            return $result[0];
        }

        public function loadCountryById(int $id):array
        {
            $result = Pais::where('id_pais', '=', $id)->get();
            if (is_null($result) || count($result)==0) {
                return NULL;
            }
            return $result[0];
        }

        public function loadStateById(int $id = null):array
        {
            $result = Estado::where('id_estado', '=', $id)->get();
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
            $user->des_email  = $usuario->getAttribute('des_email');
            $user->des_slug   = $usuario->getAttribute('des_slug');
            $user->des_senha  = $usuario->getAttribute('des_senha');
            $user->des_nome   = $usuario->getAttribute('des_nome');
            $user->des_sexo   = $usuario->getAttribute('des_sexo');
            $user->dt_nasc    = $usuario->getAttribute('dt_nasc');
            $user->des_status = $usuario->getAttribute('des_status');
            $user->save();
            return $user->id;
        }

        //---------------------------------------------------------------------
        //  UPDATES
        //---------------------------------------------------------------------
        public function email_update(string $email,int $id)
        {
            $result = $this->verifyUniqueEmail($email, $id);
            if (count($result)==0) {
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
            if ($this->verifyUniqueSlug($slug)) {
                Usuario::where('id_usuario', $id)->update(['des_slug' => $slug]);
                return TRUE;
            }
            return FALSE;
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
        public function setInfosUsuario($infos)
        {
            $usuario = array();
            $cont = 0;
            foreach ($infos as $data) {
                $usuario[$cont] = new Usuario();

                $usuario[$cont]->setAttribute('des_nome', $data['des_nome']);
                $usuario[$cont]->setAttribute('des_slug', $data['des_slug']);
                $usuario[$cont]->setAttribute('id_usuario', $data['id_usuario']);
                $usuario[$cont]->setAttribute('des_email', $data['des_email']);

                $sexo = '';
                if ($data['des_sexo'] == 'M') {
                    $sexo = 'Masculino';
                } else if ($data['des_sexo'] == 'F') {
                    $sexo = 'Feminino';
                }

                $usuario[$cont]->setAttribute('des_sexo', $sexo);
                $usuario[$cont]->setAttribute('dt_nasc', $data['dt_nasc']);
                $usuario[$cont]->setAttribute('des_apresentacao', $data['des_apresentacao']);
                $usuario[$cont]->setAttribute('des_cpf', $data['des_cpf']);
                $usuario[$cont]->setAttribute('des_foto', $data['des_foto']);

                if(!is_null($data['id_cidade'])) {
                    $cidade = $this->loadCityById($data['id_cidade'])['des_nome'] . ' - ' . $this->loadCityById($data['id_cidade'])->estado['des_uf'];
                    $usuario[$cont]->setAttribute('id_cidade', $cidade);
                }
                $usuario[$cont]->setAttribute('des_ocupacao', $data['des_ocupacao']);
                $usuario[$cont]->setAttribute('des_telefone', $data['des_telefone']);
                $usuario[$cont]->setAttribute('des_status', $data['des_status']);
                $usuario[$cont]->setAttribute('dt_cadastro', $data['dt_cadastro']);
                $cont++;
            }
            return $usuario;
        }
    }