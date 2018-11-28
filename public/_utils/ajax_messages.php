<?php

use controller\{MensagemController, ChatController};

header('Access-Control-Allow-Origin: *');
require_once('../../bootstrap/app.php');

if (isset($_POST['acao'])) {
    switch ($_POST['acao']) {
        case 'new_message':
            $mensagem = new MensagemController();
            echo $mensagem->newMessage($_POST['mensagem'], $_POST['id_chat'], $_POST['remetente']);
            break;
        case 'load_new_messages':
            $mensagem = new MensagemController();
            echo $mensagem->loadNewMessages($_POST['id_chat'], $_POST['remetente'], $_POST['destinatario']);
            break;
        case 'hire_service':
            $chat = new ChatController();
            echo $chat->hire_service($_POST['id_chat']);
            break;
        default:
            # code...
            break;
    }
}