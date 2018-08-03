<?php

namespace controller;

use model\AnuncioModel;
use model\object\ObjAnuncio;

class Anuncio
{

    //---------------------------------------------------------------------
    //  LOADS
    //---------------------------------------------------------------------
    public function loadByID (int $id)
    {
        $anuncio = AnuncioModel::where('id_anuncio', '=', $id)->get();
        $anuncios = array();
        $categoria = array();

        foreach ($anuncio as $key => $value) {
            $anuncios[$key] = new ObjAnuncio();
            $categoria[$key] = new Categoria();
            $modalidade[$key] = new Modalidade();
            $des_categoria = $categoria[$key]->loadByID($anuncio[$key]['id_categoria']);
            $des_modalidade = $modalidade[$key]->loadByID($anuncio[$key]['id_modalidade']);
            $this->setData($anuncios[$key],$anuncio[$key], $des_categoria->getDescricaoCategoria(), $des_categoria->getIconeCategoria(), $des_modalidade->getDescricaoModalidade());
        }
        return $anuncios;
    }

    public function loadByUser (int $id)
    {
        $anuncio = AnuncioModel::where('id_usuario', '=', $id)->get();
        $anuncios = array();
        $categoria = array();

        foreach ($anuncio as $key => $value) {
            $anuncios[$key] = new ObjAnuncio();
            $categoria[$key] = new Categoria();
            $modalidade[$key] = new Modalidade();
            $des_categoria = $categoria[$key]->loadByID($anuncio[$key]['id_categoria']);
            $des_modalidade = $modalidade[$key]->loadByID($anuncio[$key]['id_modalidade']);
            $this->setData($anuncios[$key],$anuncio[$key], $des_categoria->getDescricaoCategoria(), $des_categoria->getIconeCategoria(), $des_modalidade->getDescricaoModalidade());
        }
        return $anuncios;
    }

    //---------------------------------------------------------------------
    //  INSERT
    //---------------------------------------------------------------------
    public function insert (array $values)
    {
        $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
        $preco = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
        $dispon = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);
        $anuncio = new AnuncioModel();
        $anuncio->id_usuario = $values['id_usuario'];
        $anuncio->id_categoria = $values['id_categoria'];
        $anuncio->des_descricao = $descr;
        $anuncio->des_preco = $preco;
        $anuncio->id_modalidade = $values['id_modalidade'];
        $anuncio->des_disponibilidade = $dispon;
        $anuncio->save();
        return $anuncio->id;
    }

    //---------------------------------------------------------------------
    //  UPDATES
    //---------------------------------------------------------------------
    public function update (array $values)
    {
        $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
        $preco = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
        $dispon = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);
        AnuncioModel::where('id_anuncio', $values['id_anuncio'])
            ->update(['id_categoria' => $values['id_categoria'], 'des_descricao' => $descr, 'des_preco' => $preco, 'id_modalidade' => $values['id_modalidade'], 'des_disponibilidade' => $dispon]);
    }

    //---------------------------------------------------------------------
    //  TOOLS
    //---------------------------------------------------------------------
    public function delete (int $id)
    {
        AnuncioModel::where('id_anuncio', '=', $id)->delete();
    }

    //---------------------------------------------------------------------
    //  DATASET
    //---------------------------------------------------------------------
    public function setData ($anuncio, $data, $des_categoria, $des_icone_categoria, $des_modalidade)
    {
        $anuncio->setIdAnuncio($data['id_anuncio']);
        $anuncio->setIdUsuarioAnuncio($data['id_usuario']);
        $anuncio->setIdCategoriaAnuncio($data['id_categoria']);
        $anuncio->setCategoriaAnuncio($des_categoria);
        $anuncio->setIconeCategoriaAnuncio($des_icone_categoria);
        $anuncio->setDescricaoAnuncio($data['des_descricao']);
        $preco = number_format($data['des_preco'], 2, ",", ".");
        $anuncio->setPrecoAnuncio($preco);
        $anuncio->setIdModalidadeAnuncio($data['id_modalidade']);
        $anuncio->setModalidadeAnuncio($des_modalidade);
        $anuncio->setDisponibilidadeAnuncio($data['des_disponibilidade']);
    }
        
}