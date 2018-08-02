<?php

namespace controller;

use model\AnuncioModel;
use model\BuscaModel;
use model\object\ObjAnuncio;

class Busca
    {

        public function searchCount(string $q, $id)
        {
            $result = AnuncioModel::join('tb_categorias', 'tb_categorias.id_categoria', '=', 'tb_anuncios.id_categoria')
            ->join('tb_usuarios', 'tb_anuncios.id_usuario', '=', 'tb_usuarios.id_usuario')
            ->where('tb_anuncios.id_usuario', '!=', $id)
            ->orWhere('tb_categorias.des_descricao', 'LIKE', '%'.$q.'%')
            ->orWhere('tb_usuarios.des_nome', 'LIKE', '%'.$q.'%')
            ->orWhere('tb_anuncios.des_descricao', 'LIKE', '%'.$q.'%')
            ->orderBy('tb_anuncios.id_anuncio', 'desc')
            ->count();
            return $result;
        }

        public function search(string $q, $id, $limit, $to):array
        {
            $result = AnuncioModel::join('tb_categorias', 'tb_categorias.id_categoria', '=', 'tb_anuncios.id_categoria')
                ->join('tb_usuarios', 'tb_anuncios.id_usuario', '=', 'tb_usuarios.id_usuario')
                ->where('tb_anuncios.id_usuario', '!=', $id)
                ->orWhere('tb_categorias.des_descricao', 'LIKE', '%'.$q.'%')
                ->orWhere('tb_usuarios.des_nome', 'LIKE', '%'.$q.'%')
                ->orWhere('tb_anuncios.des_descricao', 'LIKE', '%'.$q.'%')
                ->orderBy('tb_anuncios.id_anuncio', 'desc')
                ->skip($limit)->take($to)
                ->get();

            $anuncios = array();
            $categoria = array();
            foreach ($result as $key => $value) {
                $anuncios[$key] = new ObjAnuncio();
                $categoria[$key] = new Categoria();
                $modalidade[$key] = new Modalidade();
                $des_categoria = $categoria[$key]->loadByID($result[$key]['id_categoria']);
                $des_modalidade = $modalidade[$key]->loadByID($result[$key]['id_modalidade']);
                $this->setData($anuncios[$key],$result[$key], $des_categoria->getDescricaoCategoria(), $des_categoria->getIconeCategoria(), $des_modalidade->getDescricaoModalidade());
            }

            return $anuncios;
        }

        public function setData (ObjAnuncio $anuncio, $data, $des_categoria, $des_icone_categoria, $des_modalidade)
        {
            $anuncio->setIdAnuncio($data['id_anuncio']);
            $anuncio->setIdUsuarioAnuncio($data['id_usuario']);
            $anuncio->setIdCategoriaAnuncio($data['id_categoria']);
            $anuncio->setCategoriaAnuncio($des_categoria);
            $anuncio->setIconeCategoriaAnuncio($des_icone_categoria);
            $anuncio->setDescricaoAnuncio($data['des_descricao']);
            $preco = number_format($data['des_preco'],2,",",".");
            $anuncio->setPrecoAnuncio($preco);
            $anuncio->setIdModalidadeAnuncio($data['id_modalidade']);
            $anuncio->setModalidadeAnuncio($des_modalidade);
            $anuncio->setDisponibilidadeAnuncio($data['des_disponibilidade']);
        }

    }