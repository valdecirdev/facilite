<?php

namespace controller;

use model\{Chat, Mensagem};

class ChatController
{

    public function loadByRecipient(int $idUser, int $idRecipient)
    {
        $chatInfos = Chat::where('id_anunciante', $idRecipient)
                      ->where('id_contratante', $idUser)->get();
        $chat = array();
        $id_chat = 0;
        foreach ($chatInfos as $key => $data) {
            $chat[$key] = new Chat();
            $chat[$key]->setAttribute('id_chat', $data['id_chat']);
            $id_chat = $data['id_chat'];
            $chat[$key]->setAttribute('id_anunciante', $data['id_anunciante']);
            $chat[$key]->setAttribute('id_contratante', $data['id_contratante']);
            $chat[$key]->setAttribute('des_status', $data['des_status']);
        }
        if($id_chat > 0){
            $msgs = Mensagem::where('id_chat', $id_chat)->update(['des_status'=>'Entregue']);
        }
        return $chat;
    }

    public function loadAll(int $idUser){
        $infos = Chat::where('id_anunciante', $idUser)
                      ->orWhere('id_contratante', $idUser)
                      ->select('tb_chats.*')
                      ->orderBy('dt_ultimaMsg', 'desc')->get();

        $chat = array();
        foreach ($infos as $key => $data) {
            $chat[$key] = new Chat();
            $chat[$key]->setAttribute('id_chat', $data['id_chat']);
            if($idUser == $data['id_anunciante']){
                $chat[$key]->setAttribute('id_anunciante', $data['id_contratante']);
                $chat[$key]->setAttribute('id_contratante', $data['id_anunciante']);
            } else {
                $chat[$key]->setAttribute('id_anunciante', $data['id_anunciante']);
                $chat[$key]->setAttribute('id_contratante', $data['id_contratante']);
            }
            $chat[$key]->setAttribute('des_status', $data['des_status']);
        }
        return $chat;
    }

    public function addChat(int $id_contratante,int $id_anunciante): void
    {
        $chat = new Chat;
        $chat->id_contratante = $id_contratante;
        $chat->id_anunciante = $id_anunciante;
        $chat->save();
    }

    public function setData($infos): array
    {
        $chat = array();
        foreach ($infos as $key => $data) {
            $chat[$key] = new Chat();
            $chat[$key]->setAttribute('id_chat', $data['id_chat']);
            $chat[$key]->setAttribute('id_anunciante', $data['id_anunciante']);
            $chat[$key]->setAttribute('id_contratante', $data['id_contratante']);
            $chat[$key]->setAttribute('des_status', $data['des_status']);
        }
        return $chat;
    }

}