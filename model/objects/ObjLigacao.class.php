<?php

class ObjLigacao {

    private $id_ligacao;
    private $id_usuario;
    private $id_contato;
    private $dt_ligacao;

    public function __construct($id_ligacao=null, $id_usuario=null, $id_contato=null, $dt_ligacao=null) {
        $this->id_ligacao   = $id_ligacao;
        $this->id_usuario   = $id_usuario;
        $this->id_contato   = $id_contato;
        $this->dt_ligacao   = $dt_ligacao;
    }

    public function getIdLigacao() {
        return $this->id_ligacao;
    }
    public function setIdLigacao($id_ligacao) {
        $this->id_ligacao = $id_ligacao;
    }
    public function getIdUsuarioLigacao() {
        return $this->id_usuario;
    }
    public function setIdUsuarioLigacao($id_usuario) {
        $this->id_usuario = $id_usuario;
    }
    public function getIdContatoLigacao() {
        return $this->id_contato;
    }
    public function setIdContatoLigacao($id_contato) {
        $this->id_contato = $id_contato;
    }
    public function getDtLigacao() {
        return $this->dt_ligacao;
    }
    public function setDtLigacao($dt_ligacao) {
        $this->dt_ligacao = $dt_ligacao;
    }
    
    

    public function __toString(){
        return json_encode(array(
            "id_ligacao"=>$this->getIdLigacao(),
            "id_usuario"=>$this->getUsuarioLigacao(),
            "id_contato"=>$this->getContatoLigacao(),
            "dt_ligacao"=>$this->getDtLigacao()
        ));
    }
} 