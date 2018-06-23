<?php

class ObjFormacao {

    private $id_formacao;
    private $id_usuario;
    private $des_titulo;
    private $des_descricao;

    function __construct($id_formacao=null, $id_usuario=null, $des_titulo=null, $des_descricao=null) {
        $this->id_formacao   = $id_formacao;
        $this->id_usuario       = $id_usuario;
        $this->des_titulo       = $des_titulo;
        $this->des_descricao    = $des_descricao;
    }

    function getIdFormacao() {
        return $this->id_formacao;
    }
    function setIdFormacao($id_formacao) {
        $this->id_formacao = $id_formacao;
    }
    function getIdUsuarioFormacao() {
        return $this->id_usuario;
    }
    function setIdUsuarioFormacao($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
    function getTituloFormacao() {
        return $this->des_titulo;
    }
    function setTituloFormacao($des_titulo) {
        $this->des_titulo = $des_titulo;
    }
    function getDescricaoFormacao() {
        return $this->des_descricao;
    }
    function setDescricaoFormacao($des_descricao) {
        $this->des_descricao = $des_descricao;
    }

    public function __toString(){
        return json_encode(array(
            "id_formacao"=>$this->getIdFormacao(),
            "id_usuario"=>$this->getIdUsuarioFormacao(),
            "des_titulo"=>$this->getTituloFormacao(),
            "des_descricao"=>$this->getDescricaoFormacao()
        ));
    }
} 