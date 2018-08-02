<?php

    namespace controller;

    use model\AnuncioModel;
    use model\CidadeModel;
    use model\ConfirmacaoModel;
    use model\EstadoModel;
    use model\ExperienciaModel;
    use model\FormacaoModel;
    use model\HabilidadeUsuarioModel;
    use model\LigacaoModel;
    use model\PaisModel;
    use model\UsuarioModel;
    use model\object\{ObjUsuario, ObjConfirmacao};
    use PHPMailer\PHPMailer\PHPMailer;

    class Usuario
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
            $user = new Usuario();
            $result = $user->verifyUniqueEmail($values['login_des_email']);
            if (count($result)>0) {
                if (password_verify($values['des_senha'], $result[0]['des_senha'])) {
                    session_start();
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
            $user = new Usuario();
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
            $usuario = new ObjUsuario(strtolower($_POST['des_email']), strtolower($slug), password_hash($_POST['des_senha'], PASSWORD_DEFAULT), mb_convert_case($_POST['des_nome'], MB_CASE_TITLE, 'UTF-8'), $_POST['des_sexo'], $_POST['dt_nasc'], "Pendente");
            if (count($user->verifyUniqueEmail($_POST['des_email']))==0) {
                $user->insert($usuario);
                $values = array(
                    'login_des_email'=>$_POST['des_email'],
                    'des_senha'=>$_POST['des_senha']
                );
                self::login($values);

                $hash = md5(date("Y/m/d H:i:s"));
                $confirm = new ObjConfirmacao(null, $_SESSION['id'], $hash);
                $confirmacao = new Confirmacao();
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
            $result = UsuarioModel::where('des_slug', '=' , $slug)->get();
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
                    $result = UsuarioModel::where('des_email', '=' , $email)->where('id_usuario', '=', $id)->get();
                    return $result;
                }
            } else {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $result = UsuarioModel::where('des_email', '=' , $email)->get();
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
            $users = UsuarioModel::where('des_slug', '=', $slug)->get();
            $usuario = $this->setInfosUsuario($users);
            return $usuario[0];
        }

        public function loadById(int $id)
        {
            $users = UsuarioModel::where('id_usuario', '=', $id)->get();
            $usuario = $this->setInfosUsuario($users);
            return $usuario[0];
        }

        public function loadByEmail(string $email)
        {
            $users = UsuarioModel::where('des_email', '=', $email)->get();
            $usuario = $this->setInfosUsuario($users);
            return $usuario[0];
        }

        public function loadCityByName(string $nome)
        {
            $result = CidadeModel::where('des_nome', '=', $nome)->get();
            return $result;
        }

        public function loadCity()
        {
            $result = CidadeModel::all();
            return $result[0];
        }

        public function loadCityById(int $id)
        {
            $result = CidadeModel::where('id_cidade', '=', $id)->get();
            return $result[0];
        }

        public function loadCountryById(int $id):array
        {
            $result = PaisModel::where('id_pais', '=', $id)->get();
            return $result[0];
        }

        public function loadStateById(int $id = null):array
        {
            $result = EstadoModel::where('id_estado', '=', $id)->get();
            return $result[0];
        }

        //---------------------------------------------------------------------
        //  INSERTS
        //---------------------------------------------------------------------
        public function insert(ObjUsuario $usuario)
        {
            $user = new UsuarioModel();
            $user->des_email = $usuario->getEmailUsuario();
            $user->des_slug = $usuario->getSlugUsuario();
            $user->des_senha = $usuario->getSenhaUsuario();
            $user->des_nome = $usuario->getNomeUsuario();
            $user->des_sexo = $usuario->getSexoUsuario();
            $user->dt_nasc = $usuario->getDtNascUsuario();
            $user->des_status = $usuario->getStatusUsuario();
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
                    UsuarioModel::where('id_usuario', $id)
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
            UsuarioModel::where('id_usuario', $id)->update([$campo => $valor]);
        }

        public function slug_update(string $slug, int $id)
        {
            $slug = str_replace(' ', '', $slug);
            $slug = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $slug ) );
            $slug = filter_var($slug, FILTER_SANITIZE_STRING);
            if ($this->verifyUniqueSlug($slug)) {
                UsuarioModel::where('id_usuario', $id)->update(['des_slug' => $slug]);
                return TRUE;
            }
            return FALSE;
        }

        public function update_image(ObjUsuario $usuario, array $files = array()):string
        {
            if ((isset($files['usrFoto']))&&(!is_null($files['usrFoto']))) {
                $foto = $usuario->getFotoUsuario();
                $diretorio = "../../view/_img/profile/";
                if (!is_dir($diretorio)) {
                    mkdir($diretorio);
                }
                if ($foto != 'default.jpg') {
                    unlink($diretorio . $foto);
                }
                $foto = md5(time()).'.jpg';

                move_uploaded_file($files['usrFoto']['tmp_name'], $diretorio.$foto);
                $this->resize_image($diretorio.$foto);

                $usuario->setFotoUsuario($foto);
                UsuarioModel::where('id_usuario', $usuario->getIdUsuario())->update(['des_foto' => $foto]);
                return $foto;
            } else {
                $foto = $usuario->getFotoUsuario();
                return $foto;
            }
        }



        //---------------------------------------------------------------------
        //  TOOLS
        //---------------------------------------------------------------------
        public function delete(int $id)
        {
            self::logout();
            AnuncioModel::where('id_usuario', '=', $id)->delete();
            ExperienciaModel::where('id_usuario', '=', $id)->delete();
            FormacaoModel::where('id_usuario', '=', $id)->delete();
            HabilidadeUsuarioModel::where('id_usuario', '=', $id)->delete();
            LigacaoModel::where('id_usuario', '=', $id)->delete();
            ConfirmacaoModel::where('id_usuario', '=', $id)->delete();
            $result = UsuarioModel::where('id_usuario', '=', $id)->get();
            $foto = $result[0]['des_foto'];
            if($foto != 'default.jpg'){
                unlink('../../view/_img/profile/'.$foto);
            }
            UsuarioModel::where('id_usuario', '=', $id)->delete();
        }

        //---------------------------------------------------------------------
        //  TOOLS
        //---------------------------------------------------------------------
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
                $usuario[$cont] = new ObjUsuario();

                $usuario[$cont]->setNomeUsuario($data['des_nome']);
                $usuario[$cont]->setSlugUsuario($data['des_slug']);
                $usuario[$cont]->setIdUsuario($data['id_usuario']);
                $usuario[$cont]->setEmailUsuario($data['des_email']);

                $sexo = '';
                if ($data['des_sexo'] == 'M') {
                    $sexo = 'Masculino';
                } else if ($data['des_sexo'] == 'F') {
                    $sexo = 'Feminino';
                }

                $usuario[$cont]->setSexoUsuario($sexo);
                $usuario[$cont]->setDtNascUsuario($data['dt_nasc']);
                $usuario[$cont]->setApresentacaoUsuario($data['des_apresentacao']);
                $usuario[$cont]->setCpfUsuario($data['des_cpf']);
                $usuario[$cont]->setFotoUsuario($data['des_foto']);

                $cidade = $this->loadCityById($data['id_cidade'])['des_nome'] . ' - ' . $this->loadCityById($data['id_cidade'])->estado['des_uf'];

                $usuario[$cont]->setCidadeUsuario($cidade);
                $usuario[$cont]->setOcupacaoUsuario($data['des_ocupacao']);
                $usuario[$cont]->setTelefoneUsuario($data['des_telefone']);
                $usuario[$cont]->setStatusUsuario($data['des_status']);
                $usuario[$cont]->setDtCadastroUsuario($data['dt_cadastro']);
                $cont++;
            }
            return $usuario;
        }
    }