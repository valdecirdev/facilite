<?php

namespace controller;

use model\{Mensagem, Chat};
use \DateTime;

class MensagemController
{

    public function newMessagesCount($idUser){
        $count = Mensagem::join('tb_chats', 'tb_chats.id_chat', '=', 'tb_mensagens.id_chat')
                         ->where('tb_mensagens.id_remetente', '!=', $idUser)
                         ->where('tb_mensagens.des_status', 'Enviada')
                         ->where('tb_chats.id_anunciante', $idUser)
                        //  ->orWhere('tb_chats.id_contratante', $idUser)
                         ->count();
        return $count;
    }

    public function newMessage($des_mensagem, $id_chat, $id_remetente)
    {
        $mensagem = new Mensagem();
        $mensagem->des_mensagem = $des_mensagem;
        $mensagem->id_chat = $id_chat;
        $mensagem->id_remetente = $id_remetente;
        $mensagem->save();

        Chat::where('id_chat', $id_chat)->update(['dt_ultimaMsg' => date("Y-m-d H:i:s")]);

        return $mensagem;
    }
    public function loadByChat(int $id)
    {
        $mensagem = Mensagem::where('id_chat', $id)->get();
        $mensagem = $this->setData($mensagem);
        return $mensagem;
    }
    public function loadNewMessages(int $id_chat, int $id_remetente, int $id_destinatario)
    {
        $mensagem = Mensagem::where('id_chat', $id_chat)
                            ->where('des_status', 'Enviada')
                            ->where(function ($query) use ($id_destinatario, $id_remetente) {
                                $query//->where('id_remetente', $id_remetente)
                                    ->where('id_remetente', $id_destinatario);
                            })->get();



        $mensagem = $this->setData($mensagem);

        Mensagem::where('id_chat', $id_chat)
        ->where(function ($query) use ($id_destinatario, $id_remetente) {
            $query->where('id_remetente', $id_destinatario);
        })->update(['des_status'=>'Entregue']);

        return json_encode($mensagem);
    }

    public function setData($infos): array
    {
        $mensagem = array();
        foreach ($infos as $key => $data) {
            $mensagem[$key] = new Mensagem();
            $mensagem[$key]->setAttribute('id_mensagem', $data['id_mensagem']);
            $mensagem[$key]->setAttribute('id_chat', $data['id_chat']);
            $mensagem[$key]->setAttribute('id_remetente', $data['id_remetente']);
            $mensagem[$key]->setAttribute('des_mensagem', $data['des_mensagem']);

            $date = new DateTime($data['dt_envio']);
            $date = $date->format('H:i').' | '.$date->format('d M');
            $mensagem[$key]->setAttribute('dt_envio', $date);
            $mensagem[$key]->setAttribute('des_status', $data['des_status']);
        }
        return $mensagem;
    }
}