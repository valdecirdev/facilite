$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(document).ready(function () {

    /**
     * Função Responsável pela ação do botão de logout e por chamar a função
     */ 
    $('#logout-user').click(function(){
        $.post('view/_utils/ajax_usuario.php',
        {
            acao: 'logout'
        },
        function(data){
            window.location.reload();
        });
    });

    /**
     * Função Responsável pela ação do botão de login e por chamar a função
     */
    $('#login-user').click(function(){
        var $email = $('#login_des_email').val();
        if( $email=="" || $email.indexOf('@')==-1 || $email.indexOf('.')==-1 ){
            $('#login_des_email').focus();
            $('#login-alert').removeClass('d-none');
        }else{        
            $.post('view/_utils/ajax_usuario.php',
            {
                acao            : 'login',
                login_des_email : $email,
                des_senha       : $('#login_des_senha').val(),
            },
            function(data){
                if(data){
                    window.location.reload();
                }else{
                    $('#login_des_email').focus();
                    $('#login-alert').removeClass('d-none');
                }
            });
        }
    });

    /**
     * Função Responsável pela ação do botão de registro e por chamar a função
     */
    $('#register-user').click(function(){
        $.post('view/_utils/ajax_usuario.php',
        {
            acao        : 'register',
            des_nome    : $('#des_nome').val(),
            des_email   : $('#des_email').val(),
            des_senha   : $('#des_senha').val(),
            des_sexo    : $('#des_sexo').val(),
            dt_nasc     : $('#dt_nasc').val(),
        },
        function(data){
            window.location.reload();
        });
    });

});