<?php

namespace vendor\model\object;

class ObjExperiencia
{

    private $id_experiencia;
    private $id_usuario;
    private $des_titulo;
    private $des_descricao;

    function __construct($id_experiencia=null, $id_usuario=null, $des_titulo=null, $des_descricao=null)
    {
        $this->id_experiencia   = $id_experiencia;
        $this->id_usuario       = $id_usuario;
        $this->des_titulo       = $des_titulo;
        $this->des_descricao    = $des_descricao;
    }

    function getIdExperiencia()
    {
        return $this->id_experiencia;
    }

    function setIdExperiencia($id_experiencia)
    {
        $this->id_experiencia = $id_experiencia;
    }

    function getIdUsuarioExperiencia()
    {
        return $this->id_usuario;
    }

    function setIdUsuarioExperiencia($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    function getTituloExperiencia()
    {
        return $this->des_titulo;
    }

    function setTituloExperiencia($des_titulo)
    {
        $this->des_titulo = $des_titulo;
    }

    function getDescricaoExperiencia()
    {
        return $this->des_descricao;
    }

    function setDescricaoExperiencia($des_descricao)
    {
        $this->des_descricao = $des_descricao;
    }

    public function __toString()
    {
        return json_encode( array(
            "id_experiencia"=>$this->getIdExperiencia(),
            "id_usuario"=>$this->getIdUsuarioExperiencia(),
            "des_titulo"=>$this->getTituloExperiencia(),
            "des_descricao"=>$this->getDescricaoExperiencia()
        ));
    }
} 