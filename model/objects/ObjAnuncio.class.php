<?php


class ObjAnuncio {

    private $id_anuncio;
    private $id_usuario;
    private $id_categoria;
    private $des_categoria;
    private $des_descricao;
    private $des_preco;
    private $id_modalidade;
    private $des_modalidade;
    private $des_disponibilidade;

    function __construct($id_anuncio=null, $id_usuario=null, $id_categoria=null, $des_categoria=null, $des_descricao=null, $des_preco=null, $id_modalidade=null, $des_modalidade=null, $des_disponibilidade=null) {
        $this->id_anuncio          = $id_anuncio;
        $this->id_usuario          = $id_usuario;
        $this->id_categoria        = $id_categoria;
        $this->des_categoria       = $des_categoria;
        $this->des_descricao       = $des_descricao;
        $this->des_preco           = $des_preco;
        $this->id_modalidade       = $id_modalidade;
        $this->des_modalidade      = $des_modalidade;
        $this->des_disponibilidade = $des_disponibilidade;
    }
    function getDisponibilidadeAnuncio() {
        return $this->des_disponibilidade;
    }
    function setDisponibilidadeAnuncio($des_disponibilidade) {
        $this->des_disponibilidade = $des_disponibilidade;
    }
    function getIdModalidadeAnuncio() {
        return $this->id_modalidade;
    }
    function setIdModalidadeAnuncio($id_modalidade) {
        $this->id_modalidade = $id_modalidade;
    }
    function getModalidadeAnuncio() {
        return $this->des_modalidade;
    }
    function setModalidadeAnuncio($des_modalidade) {
        $this->des_modalidade = $des_modalidade;
    }
    function getPrecoAnuncio() {
        return $this->des_preco;
    }
    function setPrecoAnuncio($des_preco) {
        $this->des_preco = $des_preco;
    }
    function getDescricaoAnuncio() {
        return $this->des_descricao;
    }
    function setDescricaoAnuncio($des_descricao) {
        $this->des_descricao = $des_descricao;
    }
    function getIdCategoriaAnuncio() {
        return $this->id_categoria;
    }
    function setIdCategoriaAnuncio($id_categoria) {
        $this->id_categoria = $id_categoria;
    }
    function getCategoriaAnuncio() {
        return $this->des_categoria;
    }
    function setCategoriaAnuncio($des_categoria) {
        $this->des_categoria = $des_categoria;
    }
    function getIdUsuarioAnuncio() {
        return $this->id_usuario;
    }
    function setIdUsuarioAnuncio($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
    function getIdAnuncio() {
        return $this->id_anuncio;
    }
    function setIdAnuncio($id_anuncio) {
        $this->id_anuncio = $id_anuncio;
    }
    
    public function __toString(){
        return json_encode(array(
            "id_anuncio"=>$this->getIdAnuncio(),
            "id_usuario"=>$this->getIdUsuarioAnuncio(),
            "id_categoria"=>$this->getIdCategoriaAnuncio(),,
            "des_categoria"=>$this->getCategoriaAnuncio(),
            "des_descricao"=>$this->getDescricaoAnuncio(),
            "des_preco"=>$this->getPrecoAnuncio(),
            "id_modalidade"=>$this->getIdModalidadeAnuncio(),,
            "des_modalidade"=>$this->getModalidadeAnuncio(),
            "des_disponibilidade"=>$this->getDisponibilidadeAnuncio()
        ));
    }
} 