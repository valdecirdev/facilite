<?php

use controller\{UsuarioController, ChatController, MensagemController};

$pg_title = 'Mensagem - '; ?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="theme-color" content="#29344d">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?=$description ?? 'Encontre prestadores de serviços e conecte-se a novos clientes em poucos cliques.'; ?>">

        <title><?=$pg_title; ?> Facilite Serviços</title>

        <link rel="icon" href="img/icon.png">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="css/fontawesome-all.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/sweetalert/sweetalert.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css">
        <link rel="stylesheet" href="css/chat.css">
    </head>
    <body>
    <body>
    <?php
        session_start(); 
        include('_includes'.DS.'menu.php');
        $chatExist = true;

        if(!isset($_SESSION['id']) || $_SESSION['id'] == NULL){
            header('location:home');
        }
        if(!isset($_GET['to']) || $_GET['to'] == 0){
            // header('location:erro');
            $chatExist = false;
        }
        if($chatExist){
            if($_GET['to'] == $_SESSION['id']) {
                $chatExist = false;
            }
        }

        $chats = new ChatController();
        $user = new UsuarioController();
        $usuario = $user->loadById($_SESSION['id']);

        if($chatExist){
            $destinatario = $user->loadById($_GET['to']);
            $chat = $chats->loadByRecipient($_SESSION['id'], $_GET['to']);
            if($chat == NULL){
                $chat = $chats->loadByRecipient($_GET['to'],$_SESSION['id']);
                if($chat == NULL) {
                    $chat = $chats->addChat($_SESSION['id'], $_GET['to']);
                }
            }
        }

        $chatList = $chats->loadAll($_SESSION['id']);
    ?>


<input type="text" id="id_chat" value="<?php if($chatExist){echo $chat[0]->getAttribute('id_chat');}?>" style="display: none">
<input type="text" id="id_remetente" value="<?=$_SESSION['id'];?>" style="display: none">
<input type="text" id="id_destinatario" value="<?php if($chatExist){echo $destinatario->getAttribute('id_usuario');}?>" style="display: none">
<input type="text" id="foto_destinatario" value="<?php if($chatExist){ echo $destinatario->getAttribute('des_foto');}?>" style="display: none">
    
<div class="container" id="app" style="margin-top:70px">
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Mensagens</h4>
            </div>
          </div>
          <div class="inbox_chat">
           
            <?php foreach ($chatList as $key => $value){?>

                <a href="?to=<?=$chatList[$key]->anunciante->getAttribute('id_usuario');?>"><div class="chat_list active_chat">
                    <div class="chat_people">
                        <div class="chat_img"> <img src="img/profile/<?=$chatList[$key]->anunciante->getAttribute('des_foto');?>" style="border-radius:50%"> </div>
                            <div class="chat_ib">
                            <h5><?=$chatList[$key]->anunciante->getAttribute('des_nome_exibicao');?> 
                            <!-- <span class="chat_date">Dec 25</span>-->
                                </h5>
                            <p><?=$chatList[$key]->anunciante->getAttribute('des_slug');?></p>
                            </div>
                        </div>
                    </div></a>
  
            <?php } ?>
          </div>
        </div>
        <div class="mesgs" style="background-color:#fff">
          <div class="msg_history" id="message_box">

            <?php
                if($chatExist){
                    $msg = new MensagemController();
                    $msg = $msg->loadByChat($chat[0]->getAttribute('id_chat'));
                    foreach ($msg as $key => $value){
                        if($msg[$key]['id_remetente'] == $_SESSION['id']){ ?>
                            <div class="outgoing_msg">
                                <div class="sent_msg">
                                    <p><?=$msg[$key]['des_mensagem'];?></p>
                                    <span class="time_date"><?=$msg[$key]['dt_envio'];?></span>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="incoming_msg">
                                <div class="incoming_msg_img"> <img src="img/profile/<?=$destinatario->getAttribute('des_foto');?>" style="border-radius:50%"> </div>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                        <p><?=$msg[$key]['des_mensagem'];?></p>
                                        <span class="time_date"><?=$msg[$key]['dt_envio'];?></span>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                <?php } } ?>
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
                <form @submit="checkForm">
                    <input type="text" v-model="message" id="message" class="write_msg" placeholder="Escreva uma mensagem" />
                    <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                </form>
            </div>
          </div>
        </div>
      </div>
      
    </div></div>

    
<?php include('_includes'.DS.'footer.php'); ?>
<script src="js/messages.js"></script>
</html>
    </body>
    </html>