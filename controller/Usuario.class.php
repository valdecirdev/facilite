<?php
    
    class Usuario {

        public function verifyUniqueEmail(string $email, int $id){
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $sql = new Sql();
                $result = $sql->select("SELECT id_usuario,des_nome,des_slug,des_sexo,des_senha FROM tb_usuarios WHERE des_email = :EMAIL AND id_usuario != :ID", array(
                    ":EMAIL"=>$email,
                    ":ID"=>$id
                ));
                return $result;
            }
            return null;
        }

        public function verifyUniqueSlug(string $slug){
            $sql = new Sql();
            $result = $sql->select("SELECT des_slug FROM tb_usuarios WHERE des_slug = :SLUG", array(
                ":SLUG"=>$slug,
            ));
            if(count($result)==0){
                return true;
            }
            return false;
        }

        public function slug_update(string $slug, int $id){
            $slug = str_replace(' ', '', $slug);
            $slug = filter_var($slug, FILTER_SANITIZE_STRING);
            if(self::verifyUniqueSlug($slug)){
                $sql = new Sql();
                $sql->query("UPDATE tb_usuarios SET des_slug = :SLUG WHERE id_usuario = :ID", array(
                    ":SLUG"=>$slug,
                    ":ID"=>$id
                ));
                return 1;
            }
            return 0;
        }

        public function email_update(string $email,int $id){
            $result = self::verifyUniqueEmail($email, $id);
            if(count($result)==0){
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $sql = new Sql();
                    $sql->query("UPDATE tb_usuarios SET des_email = :EMAIL WHERE id_usuario = :ID", array(
                        ":EMAIL"=>$email,
                        ":ID"=>$id
                    ));
                    return 1;
                }
            }
            return 0;
        }

        public static function logout(){
            session_start();
            session_destroy();
        }

        public static function login(array $values = array()){
            $result = self::verifyUniqueEmail($values['login_des_email'],0);
            if(count($result)>0){
                if(password_verify($values['des_senha'], $result[0]['des_senha'])){
                    session_start();
                    $_SESSION['id'] = $result[0]['id_usuario'];
                    $_SESSION['nome'] = $result[0]['des_nome'];
                    $_SESSION['slug'] = $result[0]['des_slug'];
                    $_SESSION['sexo'] = $result[0]['des_sexo'];
                    return true;
                }
            }
            return false;
        }

        public static function register(array $values = array()){
            $fullName = explode(' ', $_POST['des_nome']);
            $cont=null; $lastName = "";
            if(count($fullName) > 1){
                $lastName = $fullName[count($fullName)-1];
            }
            do {
                $slug = $fullName[0].$lastName.$cont;
                $cont++;
            } while (!self::verifyUniqueSlug($slug));
            $usuario = new UsuarioModel($_POST['des_email'], strtolower($slug), password_hash($_POST['des_senha'], PASSWORD_DEFAULT), $_POST['des_nome'], $_POST['des_sexo'], $_POST['dt_nasc']);
            if(count(self::verifyUniqueEmail($_POST['des_email'],0))==0){
                self::insert($usuario);
                $values = array(
                    'login_des_email'=>$_POST['des_email'],
                    'des_senha'=>$_POST['des_senha']
                );
                self::login($values);
            }
        }
        
        public function loadCountry(int $id):array{
            $sql = new Sql();
            $result = $sql->select("SELECT des_nome, des_sigla FROM tb_paises WHERE id_pais = :ID", array(
                ":ID"=>$id
            ));
            return $result[0];
        }

        public function loadState(int $id = null):array{
            $sql = new Sql();
            if($id != null){
                $where = ' WHERE id_estado = :ID';
                $array = array(
                    ":ID"=>$id
                );
            }else{
                $where = '';
                $array = array();
            }
            $result = $sql->select("SELECT id_estado, des_uf, id_pais FROM tb_estados".$where, $array);
            return $result; 
        }

        public function loadCity(int $id = null):array{
            $sql = new Sql();
            if($id != null){
                $where = ' WHERE id_cidade = :ID';
                $array = array(
                    ":ID"=>$id
                );
            }else{
                $where = '';
                $array = array();
            }
            $result = $sql->select("SELECT id_cidade, des_nome,id_estado FROM tb_cidades".$where." ORDER BY des_nome", $array);
            return $result;
        }

        public function loadFullCity($id){
            if(!is_null($id)){
                $cidade = self::loadCity($id);
                $estado = self::loadState($cidade[0]['id_estado']);
                return $cidade[0]['des_nome'].' - '.$estado[0]['des_uf'];
            }
            return NULL;
        }

        public function loadById(int $id):UsuarioModel{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_usuarios WHERE id_usuario = :ID", array(
                ":ID"=>$id
            ));
            $usuario = new UsuarioModel();
            self::setInfosUsuario($usuario, $result);
            return $usuario;
        }

        public function loadByEmail(string $email):UsuarioModel{
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_usuarios WHERE des_email = :EMAIL", array(
                ":EMAIL"=>$email
            ));
            $usuario = new UsuarioModel();
            self::setInfosUsuario($usuario, $result);
            return $usuario;
        }
        
        public function loadBySlug(string $slug){
            $sql = new Sql();
            $result = $sql->select("SELECT * FROM tb_usuarios WHERE des_slug = :SLUG", array(
                ":SLUG"=>$slug
            ));
            if(count($result)>0){
                $usuario = new UsuarioModel();
                self::setInfosUsuario($usuario, $result);
                return $usuario;
            }
            return null;
        }

        public function insert(UsuarioModel $usuario){
            $sql = new Sql();
            $sql->query("INSERT INTO tb_usuarios(des_email, des_slug, des_senha, des_nome, des_sexo, dt_nasc) VALUES (:EMAIL, :SLUG, :PASS, :NOME, :SEXO, :NASC)", array(
                ":EMAIL"=>$usuario->getEmailUsuario(),
                ":SLUG"=>$usuario->getSlugUsuario(),
                ":PASS"=>$usuario->getSenhaUsuario(),
                ":NOME"=>$usuario->getNomeUsuario(),
                ":SEXO"=>$usuario->getSexoUsuario(),
                ":NASC"=>$usuario->getDtNascUsuario()
            ));
        }






        public function delete(int $id){
            self::logout();
            $sql = new Sql();
            $sql->query("DELETE FROM tb_anuncios WHERE id_usuario = :ID", array(
                ":ID"=>$id
            ));
            $sql->query("DELETE FROM tb_experiencias WHERE id_usuario = :ID", array(
                ":ID"=>$id
            ));
            $sql->query("DELETE FROM tb_formacoes WHERE id_usuario = :ID", array(
                ":ID"=>$id
            ));
            $sql->query("DELETE FROM tb_habilidades_usuarios WHERE id_usuario = :ID", array(
                ":ID"=>$id
            ));
            $sql->query("DELETE FROM tb_ligacoes WHERE id_usuario = :ID OR id_contato = :ID", array(
                ":ID"=>$id
            ));

            $result = $sql->select("SELECT des_foto FROM tb_usuarios WHERE id_usuario = :ID", array(
                ":ID"=>$id
            ));
            $foto = $result[0]['des_foto'];
            if($foto != 'default.jpg'){
                unlink('../view/_img/profile/'.$foto);
            }
            $result = $sql->query("DELETE FROM tb_usuarios WHERE id_usuario = :ID", array(
                ":ID"=>$id
            ));
        }









        public function update_image(UsuarioModel $usuario, array $files = array()):string{
            if((isset($files['usrFoto']))&&(!is_null($files['usrFoto']))){
                $foto = $usuario->getFotoUsuario();
                $diretorio = "../view/_img/profile/";
                if($foto != 'default.jpg'){
                    unlink($diretorio . $foto);
                }
                $foto = md5(time()).'.jpg';

                move_uploaded_file($files['usrFoto']['tmp_name'], $diretorio.$foto);
                self::resize_image($diretorio.$foto);

                $usuario->setFotoUsuario($foto);
                $sql = new Sql();
                $sql->query("UPDATE tb_usuarios SET des_foto = :FOTO WHERE id_usuario = :ID", array(
                    ":FOTO"=>$foto,
                    ":ID"=>$usuario->getIdUsuario()
                ));
                return $foto;
            }else{
                $foto = $usuario->getFotoUsuario();
                return $foto;
            }
        }

        public function gen_update(string $campo, $valor, int $id){
            $valor = filter_var($valor, FILTER_SANITIZE_STRING);
            $sql = new Sql();
            $sql->query("UPDATE tb_usuarios SET $campo = :VALOR WHERE id_usuario = :ID", array(
                ":VALOR"=>$valor,
                ":ID"=>$id
            ));
        }

        public function setInfosUsuario(UsuarioModel $usuario, array $infos = array()){
            $usuario->setNomeUsuario($infos[0]['des_nome']);
            $usuario->setSlugUsuario($infos[0]['des_slug']);
            $usuario->setIdUsuario($infos[0]['id_usuario']);
            $usuario->setEmailUsuario($infos[0]['des_email']);
            
            if($infos[0]['des_sexo'] == 'M'){
                $sexo = 'Masculino';
            }else if($infos[0]['des_sexo'] == 'F'){
                $sexo = 'Feminino';
            }else{
                $sexo = '';
            }
            $usuario->setSexoUsuario($sexo);
            $usuario->setDtNascUsuario($infos[0]['dt_nasc']);
            $usuario->setApresentacaoUsuario($infos[0]['des_apresentacao']);
            $usuario->setCpfUsuario($infos[0]['des_cpf']);
            $usuario->setFotoUsuario($infos[0]['des_foto']);
            $usuario->setCidadeUsuario(self::loadFullCity($infos[0]['id_cidade']));
            $usuario->setOcupacaoUsuario($infos[0]['des_ocupacao']);
            $usuario->setTelefoneUsuario($infos[0]['des_telefone']);
            $usuario->setStatusUsuario($infos[0]['des_status']);
            $usuario->setDtCadastroUsuario($infos[0]['dt_cadastro']);
        }

        public function resize_image(string $caminho_imagem){
            // Retorna o identificador da imagem
            $imagem = imagecreatefromjpeg($caminho_imagem);
            // Cria duas variáveis com a largura e altura da imagem
            list( $largura, $altura ) = getimagesize( $caminho_imagem );
            
            // Nova largura e altura
            // $proporcao = 0.5;
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
    }
