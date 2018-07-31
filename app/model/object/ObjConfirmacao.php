<?php

namespace model\object;

class ObjConfirmacao
{
    private $id_confirmacao;
    private $id_usuario;
    private $des_hash;

    public function __construct($id_confirmacao = null, $id_usuario = null, $des_hash = null)
    {
        $this->id_confirmacao = $id_confirmacao;
        $this->id_usuario = $id_usuario;
        $this->des_hash = $des_hash;
    }

    public function getIdConfirmacao()
    {
        return $this->id_confirmacao;
    }

    public function setIdConfirmacao($id_confirmacao): void
    {
        $this->id_confirmacao = $id_confirmacao;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function setIdUsuario($id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function getDesHash()
    {
        return $this->des_hash;
    }

    public function setDesHash($des_hash): void
    {
        $this->des_hash = $des_hash;
    }

    public function __toString()
    {
        return json_encode( array(
            "id_confirmacao"=>$this->getIdConfirmacao(),
            "id_usuario"=>$this->getIdUsuario(),
            "des_hash"=>$this->getDesHash()
        ));
    }

}