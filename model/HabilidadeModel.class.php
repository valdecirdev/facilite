<?php

class HabilidadeModel {

    private $id_habilidade;
    private $id_usuario;
    private $des_descricao;
    private $des_nivel;
    private $des_status;

    function __construct($id_habilidade=null, $id_usuario=null, $des_descricao=null, $des_nivel=null, $des_status=null) {
        $this->id_habilidade    = $id_habilidade;
        $this->id_usuario       = $id_usuario;
        $this->des_descricao    = $des_descricao;
        $this->des_nivel        = $des_nivel;
        $this->des_status       = $des_status;
    }

    function getIdHabilidade() {
        return $this->id_habilidade;
    }
    function setIdHabilidade($id_habilidade) {
        $this->id_habilidade = $id_habilidade;
    }
    function getIdUsuarioHabilidade() {
        return $this->id_usuario;
    }
    function setIdUsuarioHabilidade($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
    function getDescricaoHabilidade() {
        return $this->des_descricao;
    }
    function setDescricaoHabilidade($des_descricao) {
        $this->des_descricao = $des_descricao;
    }
    function getNivelHabilidade() {
        return $this->des_nivel;
    }
    function setNivelHabilidade($des_nivel) {
        $this->des_nivel = $des_nivel;
    }
    function getStatusHabilidade() {
        return $this->des_status;
    }
    function setStatusHabilidade($des_status) {
        $this->des_status = $des_status;
    }


    public function __toString(){
        return json_encode(array(
            "id_usuario"=>$this->getIdUsuarioHabilidade(),
            "id_habilidade"=>$this->getIdHabilidade(),
            "des_descricao"=>$this->getDescricaoHabilidade(),
            "des_nivel"=>$this->getNivelHabilidade(),
            "des_status"=>$this->getStatusHabilidade()
        ));
    }
} 