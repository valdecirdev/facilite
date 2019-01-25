<?php

namespace Controller;

use Models\{Anuncio, Usuario};
use Core\Controller;

class BuscaController extends Controller
{
    public function index()
    {
        session_start();
        if(isset($_SESSION['logged'])){
            $logged_user = Usuario::where('id_usuario', $_SESSION['id'])->get()[0];
        }
        require BASEPATH."resources/view/search.php";
    }

    public function searchCount(string $q, $id, $categoria = NULL, $min_price = NULL, $max_price = NULL): int
    {
        $q = strip_tags($q);
        $result = Anuncio::query()
                    ->join('tb_categorias', 'tb_categorias.id_categoria', '=', 'tb_anuncios.id_categoria')
                    ->join('tb_usuarios', 'tb_anuncios.id_usuario', '=', 'tb_usuarios.id_usuario')
                    ->where('tb_anuncios.id_usuario', '!=', $id)
                    // Filtra a categoria
                    ->when($categoria != NULL, function ($query) use ($categoria) {
                        return $query->where('tb_categorias.des_descricao', $categoria);
                    })
                    // Filtra o Preço
                    ->when($max_price != NULL && $min_price != NULL, function ($query) use ($min_price, $max_price) {
                        return $query->whereBetween('tb_anuncios.des_preco', [$min_price, $max_price]);
                    })
                    ->when($min_price != NULL, function ($query) use ($min_price) {
                        return $query->where('tb_anuncios.des_preco', '>=', $min_price);
                    })
                    ->when($max_price != NULL, function ($query) use ($max_price) {
                        return $query->where('tb_anuncios.des_preco', '<=', $max_price);
                    })
                    // Filtra a descricao e o nome de usuario
                    ->where(function ($query) use ($q) {
                        $query->where('tb_categorias.des_descricao', 'LIKE', '%'.$q.'%')
                            ->orWhere('tb_anuncios.des_descricao', 'LIKE', '%'.$q.'%')
                            ->orwhere('tb_usuarios.des_nome', 'LIKE', '%'.$q.'%');
                    })
                    ->select('tb_anuncios.*', 'tb_categorias.id_categoria', 'tb_usuarios.des_nome')
                    ->count();
            return $result;
            // ->avg('tb_anuncios.des_preco');
        }








        public function search(string $q, $id, $limit, $to, $ord = NULL, $categoria = NULL, $min_price = NULL, $max_price = NULL):array
        {
            $q = strip_tags($q);
            $campo = 'tb_anuncios.id_anuncio';
            $ordem = 'desc';
            if($ord == 'lowest') {
                $campo = 'tb_anuncios.des_preco';
                $ordem = 'asc';
            }
            if($ord == 'biggest') {
                $campo = 'tb_anuncios.des_preco';
                $ordem = 'desc';
            }
            $result = Anuncio::query()
                    ->join('tb_categorias', 'tb_categorias.id_categoria', '=', 'tb_anuncios.id_categoria')
                    ->join('tb_usuarios', 'tb_anuncios.id_usuario', '=', 'tb_usuarios.id_usuario')
                    ->having('tb_anuncios.id_usuario', '!=', $id)
                    // Filtra a categoria
                    ->when($categoria != NULL, function ($query) use ($categoria) {
                        return $query->where('tb_categorias.des_descricao', $categoria);
                    })
                    // Filtra o Preço
                    ->when($max_price != NULL && $min_price != NULL, function ($query) use ($min_price, $max_price) {
                        return $query->whereBetween('tb_anuncios.des_preco', [$min_price, $max_price]);
                    })
                    ->when($min_price != NULL, function ($query) use ($min_price) {
                        return $query->where('tb_anuncios.des_preco', '>=', $min_price);
                    })
                    ->when($max_price != NULL, function ($query) use ($max_price) {
                        return $query->where('tb_anuncios.des_preco', '<=', $max_price);
                    })
                    // Filtra a descricao e o nome de usuario
                    ->where(function ($query) use ($q) {
                        $query->where('tb_categorias.des_descricao', 'LIKE', '%'.$q.'%')
                            ->orWhere('tb_anuncios.des_descricao', 'LIKE', '%'.$q.'%')
                            ->orwhere('tb_usuarios.des_nome', 'LIKE', '%'.$q.'%');
                    })
                    ->select('tb_anuncios.*', 'tb_categorias.id_categoria', 'tb_usuarios.des_nome')
                    ->orderBy($campo, $ordem)
                    ->skip($limit)->take($to)
                    ->get();

            $anuncios = $this->setData($result);
            return $anuncios;
        }

        public function setData ($infos) :array
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