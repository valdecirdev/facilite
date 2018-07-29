<?php

namespace object;

class ObjCategoria
{

    private $id_categoria;
    private $des_descricao;
    private $des_icone;

    function __construct($id_categoria=null, $des_descricao=null, $des_icone=null)
    {
        $this->id_categoria     = $id_categoria;
        $this->des_descricao    = $des_descricao;
        $this->des_icone        = $des_icone;
    }

    function getIdCategoria()
    {
        return $this->id_categoria;
    }

    function setIdCategoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;
    }

    function getDescricaoCategoria()
    {
        return $this->des_descricao;
    }

    function setDescricaoCategoria($des_descricao)
    {
        $this->des_descricao = $des_descricao;
    }

    function getIconeCategoria()
    {
        return $this->des_icone;
    }

    function setIconeCategoria($des_icone)
    {
        $this->des_icone = $des_icone;
    }
    

    public function __toString()
    {
        return json_encode( array(
            "id_categoria"=>$this->getIdCategoria(),
            "des_descricao"=>$this->getDescricaoCategoria(),
            "des_icone"=>$this->getIconeCategoria()
        ));
    }
} 