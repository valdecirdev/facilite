<?php

namespace controller;

use model\UsuarioModel;

class Usuario {

    public function loadBySlug(string $slug)
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->loadBySlug($slug);
    }

    public function slug_update(string $slug, int $id)
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->slug_update($slug, $id);
    }

    public function email_update(string $email,int $id)
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->email_update($email, $id);
    }

    public static function logout(){
        $UsuarioModel = new UsuarioModel();
        $UsuarioModel->logout();
    }

    public static function login(array $values = array())
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->login($values);
    }

    public static function register(array $values = array())
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->register($values);
    }
        
    public function loadCity(int $id = null):array
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->loadCity($id);
    }

    public function loadById(int $id)
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->loadById($id);
    }

    public function loadByEmail(string $email)
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->loadByEmail($email);
    }

    public function insert($usuario)
    {
        $UsuarioModel = new UsuarioModel();
        $UsuarioModel->loadByEmail($usuario);
    }

    public function update_image($usuario, array $files = array()):string
    {
        $UsuarioModel = new UsuarioModel();
        return $UsuarioModel->update_image($usuario, $files);
    }

    public function gen_update(string $campo, $valor, int $id)
    {
        $UsuarioModel = new UsuarioModel();
        $UsuarioModel->gen_update($campo, $valor, $id);
    }

    public function delete(int $id)
    {
        $UsuarioModel = new UsuarioModel();
        $UsuarioModel->delete($id);
    }

}
