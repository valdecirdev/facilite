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
        $anuncio = Anuncio::where('id_anuncio', $id)->get();
        $anuncio = $this->setData($anuncio);
        return $anuncio[0];
    }

    public function loadByUser (int $id): array
    {
        $anuncios = Anuncio::where('id_usuario', $id)->get();
        $anuncios = $this->setData($anuncios);
        return $anuncios;
    }

    //---------------------------------------------------------------------
    //  INSERT
    //---------------------------------------------------------------------
    public function insert (array $values): int
    {
        $values['des_descricao']  = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
        $values['des_preco']  = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
        $values['des_disponibilidade'] = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);

        $anuncio = new Anuncio();
        $anuncio->setAttribute('id_usuario', $values['id_usuario']);
        $anuncio->setAttribute('id_categoria', $values['id_categoria']);
        $anuncio->setAttribute('des_descricao', $values['des_descricao']);
        $anuncio->setAttribute('des_preco', $values['des_preco']);
        $anuncio->setAttribute('id_modalidade', $values['id_modalidade']);
        $anuncio->setAttribute('des_disponibilidade', $values['des_disponibilidade']);
        $anuncio->save();
        return $anuncio->id;
    }

    //---------------------------------------------------------------------
    //  UPDATES
    //---------------------------------------------------------------------
    public function update (array $values): void
    {
        $values['des_descricao'] = filter_var($values['des_descricao'], FILTER_SANITIZE_STRING);
        $values['des_preco'] = filter_var($values['des_preco'], FILTER_SANITIZE_STRING);
        $values['des_disponibilidade'] = filter_var($values['des_disponibilidade'], FILTER_SANITIZE_STRING);
        Anuncio::where('id_anuncio', $values['id_anuncio'])->update(['id_categoria' => $values['id_categoria'], 'des_descricao' => $values['des_descricao'], 'des_preco' => $values['des_preco'], 'id_modalidade' => $values['id_modalidade'], 'des_disponibilidade' => $values['des_disponibilidade']]);
    }

    //---------------------------------------------------------------------
    //  TOOLS
    //---------------------------------------------------------------------
    public function delete (int $id): void
    {
        Anuncio::where('id_anuncio', $id)->delete();
    }

    //---------------------------------------------------------------------
    //  DATASET
    //---------------------------------------------------------------------
    public function setData (array $infos): array
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