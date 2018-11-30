
$(document).ready(function () {    
    
    /* -------------------------------------------------------------------------------------------------
     *      SESSÃO SOBRE
     * ------------------------------------------------------------------------------------------------- */ 
        
        // BOTAO DE SALVAR APRENSENTACAO
        $('#btn-avaliar').click(function(){
            $.post('../post/avaliar_servico',
            {
                comentario: $('#des_comentario').val(),
                nota: $('#des_nota').val(),
                id_usuario: $('#id_usuario').val(),
                id_anuncio: $('#id_anuncio').val(),
            },function(data){
                $('#list-avaliacoes').append('<div class="row" style="margin-top: 15px"><div class="col-1"><a href=""><img src="" alt="" class="rounded-circle" height="50"></a></div><div class="col-10"><p><i class="fa fa-star" style="font-size: 15px;color:rgb(255, 208, 0)"></i> '+nota+' - '+comentario+'</p><p style="margin-top:-10px"><a href="">'+'teste'+'</a></p></div></div>');
                swal({
                    title: "Sucesso!",
                    text: "Obrigado por avaliar!",
                    timer: 2000,
                    type: "success" 
                    }
                );
            });
        });
    
    });