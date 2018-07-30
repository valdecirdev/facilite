<?php

namespace vendor\model\object;

class ObjHabilidade
{

    private $id_habilidade;
    private $id_usuario;
    private $des_descricao;

    function __construct($id_habilidade = null, $id_usuario = null, $des_descricao = null)
    {
        $this->id_habilidade    = $id_habilidade;
        $this->id_usuario       = $id_usuario;
        $this->des_descricao    = $des_descricao;
    }

    function getIdHabilidade()
    {
        return $this->id_habilidade;
    }

    function setIdHabilidade($id_habilidade)
    {
        $this->id_habilidade = $id_habilidade;
    }

    function getIdUsuarioHabilidade()
    {
        return $this->id_usuario;
    }

    function setIdUsuarioHabilidade($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    function getDescricaoHabilidade()
    {
        return $this->des_descricao;
    }

    function setDescricaoHabilidade($des_descricao)
    {
        $this->des_descricao = $des_descricao;
    }

    public function __toString()
    {
        return json_encode(array(
            "id_usuario"=>$this->getIdUsuarioHabilidade(),
            "id_habilidade"=>$this->getIdHabilidade(),
            "des_descricao"=>$this->getDescricaoHabilidade()
        ));
    }
} 