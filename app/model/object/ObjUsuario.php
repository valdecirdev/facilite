<?php

namespace model\object;

use \DateTime;

class ObjUsuario
{

    private $id_usuario;
    private $slug_usuario;
    private $email_usuario;
    private $senha_usuario;
    private $nome_usuario;
    private $sexo_usuario;
    private $dtnasc_usuario;
    private $des_apresentacao;
    private $cpf_usuario;
    private $foto_usuario;
    private $cidade_usuario;
    private $telefone_usuario;
    private $ocupacao_usuario;
    private $status_usuario;
    private $dtcadastro_usuario;

    function __construct($email_usuario=null, $slug_usuario=null, $senha_usuario=null, $nome_usuario=null, $sexo_usuario=null, $dtnasc_usuario=null, $status_usuario = null) {
        $this->email_usuario    = $email_usuario;
        $this->slug_usuario     = $slug_usuario;
        $this->senha_usuario    = $senha_usuario;
        $this->nome_usuario     = $nome_usuario;
        $this->sexo_usuario     = $sexo_usuario;
        $this->dtnasc_usuario   = $dtnasc_usuario;
        $this->status_usuario   = $status_usuario;
    }

    public function getIdadeUsuario()
    {
        $date = new DateTime( $this::getDtNascUsuario() ); // data de nascimento
        $interval = $date->diff( new DateTime( date('Y-m-d') ) ); // data definida
        return $interval->format( '%Y' );
    }

    public function getNomeSimplesUsuario()
    {
        $nome = explode(' ', $this->nome_usuario);
        if (count($nome) > 1) {
            return $nome[0].' '.$nome[count($nome)-1];
        }
        return $nome[0];
    }

    public function getNomeUsuario()
    {
        return $this->nome_usuario;
    }

    public function setNomeUsuario($nome_usuario)
    {
        $this->nome_usuario = $nome_usuario;
    }

    public function getApresentacaoUsuario()
    {
        return $this->des_apresentacao;
    }

    public function setApresentacaoUsuario($des_apresentacao)
    {
        $this->des_apresentacao = $des_apresentacao;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function getSlugUsuario()
    {
        return $this->slug_usuario;
    }

    public function setSlugUsuario($slug_usuario)
    {
        $this->slug_usuario = $slug_usuario;
    }

    public function getEmailUsuario() {
        return $this->email_usuario;
    }

    public function setEmailUsuario($email_usuario)
    {
        $this->email_usuario = $email_usuario;
    }

    public function getSenhaUsuario()
    {
        return $this->senha_usuario;
    }

    public function setSenhaUsuario($senha_usuario)
    {
        $this->senha_usuario = $senha_usuario;
    }
    public function getSexoUsuario()
    {
        return $this->sexo_usuario;
    }

    public function setSexoUsuario($sexo_usuario)
    {
        $this->sexo_usuario = $sexo_usuario;
    }

    public function getDtNascUsuario()
    {
        return $this->dtnasc_usuario;
    }

    public function setDtNascUsuario($dtnasc_usuario)
    {
        $this->dtnasc_usuario = $dtnasc_usuario;
    }

    public function getFotoUsuario()
    {
        return $this->foto_usuario;
    }

    public function setFotoUsuario($foto_usuario)
    {
        $this->foto_usuario = $foto_usuario;
    }

    public function getCidadeUsuario()
    {
        return $this->cidade_usuario;
    }

    public function setCidadeUsuario($cidade_usuario)
    {
        $this->cidade_usuario = $cidade_usuario;
    }

    public function getTelefoneUsuario()
    {
        return $this->telefone_usuario;
    }

    public function setTelefoneUsuario($telefone_usuario)
    {
        $this->telefone_usuario = $telefone_usuario;
    }

    public function getOcupacaoUsuario()
    {
        return $this->ocupacao_usuario;
    }

    public function setOcupacaoUsuario($ocupacao_usuario)
    {
        $this->ocupacao_usuario = $ocupacao_usuario;
    }

    public function getStatusUsuario()
    {
        return $this->status_usuario;
    }

    public function setStatusUsuario($status_usuario)
    {
        $this->status_usuario = $status_usuario;
    }

    public function getDtCadastroUsuario()
    {
        return $this->dtcadastro_usuario;
    }

    public function setDtCadastroUsuario($dtcadastro_usuario)
    {
        $this->dtcadastro_usuario = $dtcadastro_usuario;
    }

    public function setCpfUsuario($cpf_usuario)
    {
        $this->cpf_usuario = $cpf_usuario;
    }

    public function getCpfUsuario()
    {
        return $this->cpf_usuario;
    }
    
    public function __toString()
    {
        return json_encode(array(
            "id_usuario"=>$this::getIdUsuario(),
            "email_usuario"=>$this::getEmailUsuario(),
            "nome_usuario"=>$this::getNomeUsuario(),
            "slug_usuario"=>$this::getSlugUsuario(),
            "nome_simples_usuario"=>$this::getNomeSimplesUsuario(),
            "sexo_usuario"=>$this::getSexoUsuario(),
            "dtnasc_usuario"=>$this::getDtNascUsuario(),
            "des_apresentacao"=>$this::getApresentacaoUsuario(),
            "cpf_usuario"=>$this::getCpfUsuario(),
            "foto_usuario"=>$this::getFotoUsuario(),
            "cidade_usuario"=>$this::getCidadeUsuario(),
            "telefone_usuario"=>$this::getTelefoneUsuario(),
            "ocupacao_usuario"=>$this::getOcupacaoUsuario(),
            "status_usuario"=>$this::getStatusUsuario(),
            "dtcadastro_usuario"=>$this::getDtCadastroUsuario()
        ));
    }
} 
