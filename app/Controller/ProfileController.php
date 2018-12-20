<?php

    namespace Controller;

    use Models\Usuario;
    use Core\Controller;

    class ProfileController extends Controller
    {

        public function index ($slug)
        {
            $usuario = Usuario::where('des_slug', $slug)->get()[0] ?? header('location:erro');
            
            session_start();
            $logged_user = NULL;
            $dono_perfil = owner_session($usuario->id_usuario);
            if ($dono_perfil) {
                $logged_user = $usuario;
            } else if(auth()) {
                $logged_user = Usuario::where('id_usuario', $_SESSION['id'])->get()[0];
            }

            $pg_title = $usuario->getAttribute('des_nome_exibicao').' - ';
            $description = $usuario->getAttribute('des_apresentacao');

            require BASEPATH."resources/view/profile.php";
        }


        public function updateApresentacao($valor, $id_usuario): bool
        {
            $valor = filter_var($valor, FILTER_SANITIZE_STRING);
            Usuario::where('id_usuario', $id_usuario)->update(['des_apresentacao' => $valor]);
            return TRUE;
        }


        public function updateAvatar($avatar)
        {
            session_start();
            $usuario = Usuario::where('id_usuario', $_SESSION['id'])->get()[0];


            if ((!isset($avatar['usrFoto'])) || (is_null($avatar['usrFoto']))) {
                $foto = $usuario->des_foto;
                return $foto;
            }
            $foto = $usuario->des_foto;
            $diretorio = dirname(__DIR__).DS.'..'.DS.'public'.DS.'img'.DS.'profile'.DS;
            if (!is_dir($diretorio)) {
                mkdir($diretorio);
            }
            if (($foto != 'default.jpg') && ($foto != 'woman-avatar.jpg') && ($foto != 'man-avatar.jpg') && (file_exists($diretorio . $foto))) {
                unlink($diretorio . $foto);
            }
            $foto = md5(time()).'.jpg';

            move_uploaded_file($avatar['usrFoto']['tmp_name'], $diretorio.$foto);
            $this->resizeImage($diretorio.$foto, 150, 150);

            Usuario::where('id_usuario', $usuario->id_usuario)->update(['des_foto' => $foto]);
            return $foto;
        }

        public function updateCover($cover)
        {
            session_start();
            $usuario = Usuario::where('id_usuario', $_SESSION['id'])->get()[0];


            if ((!isset($cover['usrCapa'])) || (is_null($cover['usrCapa']))) {
                $foto = $usuario->des_capa;
                return $foto;
            }
            $foto = $usuario->des_capa;
            $diretorio = dirname(__DIR__).DS.'..'.DS.'public'.DS.'img'.DS.'cover'.DS;
            if (!is_dir($diretorio)) {
                mkdir($diretorio);
            }
            if (($foto != 'cover.jpg') && (file_exists($diretorio . $foto))) {
                unlink($diretorio . $foto);
            }
            $foto = md5(time()).'.jpg';

            move_uploaded_file($cover['usrCapa']['tmp_name'], $diretorio.$foto);
            
            $this->resizeImage($diretorio.$foto, 250, 150);

            Usuario::where('id_usuario', $usuario->id_usuario)->update(['des_capa' => $foto]);
            return $foto;
        }


        public function resizeImage(string $caminho_imagem, $largura_final, $altura_final): void
        {
            // Retorna o identificador da imagem
            $imagem = imagecreatefromjpeg($caminho_imagem);
            // Cria duas variáveis com a largura e altura da imagem
            list( $largura, $altura ) = getimagesize( $caminho_imagem );

            // Nova largura e altura
            $nova_largura = $largura_final; //* $proporcao;
            $nova_altura = $altura_final;// * $proporcao;

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
    
    }