<?php

namespace model\object;

class ObjModalidade
{

    private $id_modalidade;
    private $des_descricao;

    function __construct($id_modalidade=null, $des_descricao=null)
    {
        $this->id_modalidade     = $id_modalidade;
        $this->des_descricao    = $des_descricao;
    }

    function getIdModalidade()
    {
        return $this->id_modalidade;
    }

    function setIdModalidade($id_modalidade)
    {
        $this->id_modalidade = $id_modalidade;
    }

    function getDescricaoModalidade() {
        return $this->des_descricao;
    }

    function setDescricaoModalidade($des_descricao) {
        $this->des_descricao = $des_descricao;
    }

    public function __toString(){
        return json_encode(array(
            "id_modalidade"=>$this->getIdModalidade(),
            "des_descricao"=>$this->getDescricaoModalidade()
        ));
    }
} 