$(document).ready(function(){

    var elem = document.getElementById('message_box');
    elem.scrollTop = elem.scrollHeight;

    $('#countNewMessages').hide();

    function loadNewMessages(){
        let id_chat = $('#id_chat');
        let id_remetente = $('#id_remetente');
        let id_destinatario = $('#id_destinatario');
        let foto_destinatario = $('#foto_destinatario');
        $.post('_utils/ajax_messages.php',
                    {
                        acao             : 'load_new_messages',
                        remetente        : id_remetente.val(),
                        destinatario     : id_destinatario.val(),
                        id_chat          : id_chat.val(),
                    },
                    function(data){
                        data = JSON.parse(data);
                        for (i = 0; i < data.length; i++) {
                            $('#message_box').append('<div class="incoming_msg"><div class="incoming_msg_img"> <img src="img/profile/'+foto_destinatario.val()+'" style="border-radius:50%"> </div><div class="received_msg"><div class="received_withd_msg"><p>'+data[i].des_mensagem+'</p><span class="time_date">'+data[i].dt_envio+'</span> </div></div></div>');
                            var elem = document.getElementById('message_box');
                            elem.scrollTop = elem.scrollHeight;
                        }
                    });
    }

    setInterval(function(){ loadNewMessages(); }, 3000);

});

var app = new Vue({
    el: '#app',
    data: {
        message: '',
    },
    methods: {
        checkForm: function (e) {
            let id_chat = $('#id_chat');
            let id_remetente = $('#id_remetente');
            let meu_nome = $('#meu_nome');

            if(!this.message){

            }else  {
                $.post('_utils/ajax_messages.php',
                    {
                        acao             : 'new_message',
                        mensagem         : this.message,
                        remetente        : id_remetente.val(),
                        id_chat          : id_chat.val(),
                    },
                    function(data){
                        $('#message_box').append('<div class="outgoing_msg"><div class="sent_msg"><p>'+$('#message').val()+'</p><span class="time_date">'+new Date().toLocaleString()+'</span></div></div>');
                        $('#message').val('');
                        var elem = document.getElementById('message_box');
                        elem.scrollTop = elem.scrollHeight;
                    });
            }
            e.preventDefault();
        }
    }
})