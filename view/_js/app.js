$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

$(document).ready(function () {

    /**
     * Função Responsável pela ação do botão de logout e por chamar a função
     */ 
    $('#logout-user').click(function(){
        $.post('view/_utils/ajax_perfil.php',
        {
            acao: 'logout'
        },
        function(data){
            window.location.reload();
        });
    });

});