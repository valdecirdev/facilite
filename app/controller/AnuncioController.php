<?php

namespace controller;

use model\Anuncio;

class AnuncioController
{

    //---------------------------------------------------------------------
    //  LOADS
    //---------------------------------------------------------------------
    public function loadByID (int $id): Anuncio
    {
        $result = Anuncio::where('id_anuncio', '=', $id)->get();
        $anuncios = $this->setData($result);
        return $anuncios[0];
    }

    public function loadByUser (int $id): array
    {
        $result = Anuncio::where('id_usuario', '=', $id)->get();
        $anuncios = $this->setData($result);
        return $anuncios;
    }

    //---------------------------------------------------------------------
    //  INSERT
    //---------------------------------------------------------------------
    public function insert (array $values): int
    {
        $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
        $preco = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
        $dispon = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);
        $anuncio = new Anuncio();
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
    public function update (array $values): void
    {
        $descr = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
        $preco = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
        $dispon = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);
        Anuncio::where('id_anuncio', $values['id_anuncio'])
            ->update(['id_categoria' => $values['id_categoria'], 'des_descricao' => $descr, 'des_preco' => $preco, 'id_modalidade' => $values['id_modalidade'], 'des_disponibilidade' => $dispon]);
    }

    //---------------------------------------------------------------------
    //  TOOLS
    //---------------------------------------------------------------------
    public function delete (int $id): void
    {
        Anuncio::where('id_anuncio', '=', $id)->delete();
    }

    //---------------------------------------------------------------------
    //  DATASET
    //---------------------------------------------------------------------
    public function setData ($infos)
    {
        $anuncios = array();
        foreach ($infos as $key => $data) {
            $anuncios[$key] = new Anuncio();
            $anuncios[$key]->setAttribute('id_anuncio', $data['id_anuncio']);
            $anuncios[$key]->setAttribute('id_usuario', $data['id_usuario']);
            $anuncios[$key]->setAttribute('id_categoria', $data['id_categoria']);
            $anuncios[$key]->setAttribute('des_descricao', $data['des_descricao']);
            $preco = number_format($data['des_preco'], 2, ",", ".");
            $anuncios[$key]->setAttribute('des_preco', $preco);
            $anuncios[$key]->setAttribute('id_modalidade', $data['id_modalidade']);
            $anuncios[$key]->setAttribute('des_disponibilidade', $data['des_disponibilidade']);
        }
        return $anuncios;
    }
        
}