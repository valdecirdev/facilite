
$(document).ready(function () {
   

/* -------------------------------------------------------------------------------------------------
 *      FUNÇÕES GERAIS
 * ------------------------------------------------------------------------------------------------- */ 
   
/** @description Calcula a idade do usuario com base na data de nascimento informada ;
 *  @param {number} nascimento Data de nascimento do usuário
 *  @return {number} Idade do usuário 
 */ 
/**
     * Função Responsável por calcular a idade do usuario com base na data de nascimento informada
     */  
    function calcularIdade(nascimento) {
        hoje = new Date;
        nascimento = new Date(nascimento);
        var idade = hoje.getFullYear() - nascimento.getFullYear();
        if ( new Date(hoje.getFullYear(), hoje.getMonth(), hoje.getDate()) < 
             new Date(hoje.getFullYear(), nascimento.getMonth(), nascimento.getDate()) )
             idade--;
        return idade;
    }


/* -------------------------------------------------------------------------------------------------
 *      ALTERAR FOTO DE PERFIL
 * ------------------------------------------------------------------------------------------------- */ 
 
/** @description Abre a caixa de dialogo para seleção de foto após clique na foto de perfil.  
 */ 
    $("#usrFotoView").click(function (e) {
        $('#usrFoto').click(); // Open dialog
        e.preventDefault();
    });
/** @description Abre a caixa de dialogo para seleção de foto após clique no icone de camera da foto de 
 * perfil. 
 */  
    $("#fotoMouseOn").click(function (e) {
        $('#usrFoto').click(); // Open dialog
        e.preventDefault();
    });
/** @description Exibe imagem da camera sobre a foto de perfil.  
 */ 
    $("#fotoMouseOn").mouseover(function() {
        $("#fotoMouseOn").css('display','block');
    });
/** @description Esconde imagem da camera sobre a foto de perfil.  
 */ 
    $("#fotoMouseOn").mouseout(function() {
        $("#fotoMouseOn").css('display','none');
    });
/** @description Exibe imagem da camera sobre a foto de perfil.  
 */ 
    $("#usrFotoView").mouseover(function() {
        $("#fotoMouseOn").css('display','block');
    });
/** @description Executa a ação do botão Adicionar/Remover Contato.  
 */ 
    $("#usrFoto").change(function(){
        $('#form-usrFoto').submit();        
    });

/** @description Faz o envio do formulario com a nova imagem de perfil e atualiza automaticamente na pagina. 
 */ 
    $("#form-usrFoto").submit(function(e) {
        if($("#usrFoto").val() != ''){
            var form;
            form = new FormData();
            form.append('usrFoto', event.target.files[0]); // para enviar apenas 1 arquivo
            $.ajax({
                url: "controller/json_Usuario.php", // Url do lado server que vai receber o arquivo
                data: form,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    $('#usrFotoView').attr('src','view/_img/profile/'+data);
                    $('.img-nav-profile').attr('src','view/_img/profile/'+data);
                }
            });
        }
        e.preventDefault();
    });



/* -------------------------------------------------------------------------------------------------
 *      BOTÃO ADICIONAR/REMOVER CONTATO
 * ------------------------------------------------------------------------------------------------- */ 

/** @description Executa a ação do botão Adicionar/Remover Contato.  
 *  @param {Element} btn_action Recebe o botão clicado.  
 */ 
    function btn_criar_conexao_profile(btn_action){
        if($(btn_action).hasClass('btn-fc-primary')){
            $(btn_action).text('Remover Contato');
            $(btn_action).removeClass('btn-fc-primary');
            $(btn_action).addClass('btn-fc-danger');

            $.post('controller/json_Usuario.php',
            {
                acao: 'ad_conexao',
                id_usuario: $('#id_usuario_logado').val(),
                id_contato: $('#id_usuario').val(),
            });
        }else{
            $(btn_action).text('Adicionar Contato');
            $(btn_action).removeClass('btn-fc-danger');
            $(btn_action).addClass('btn-fc-primary');
            $.post('controller/json_Usuario.php',
            {
                acao: 'rem_conexao',
                id_usuario: $('#id_usuario_logado').val(),
                id_contato: $('#id_usuario').val(),
            });
        }
    }


/* -------------------------------------------------------------------------------------------------
 *      SESSÃO EXPERIENCIAS
 * ------------------------------------------------------------------------------------------------- */ 

/** @description Executa a ação do botão editar experiencia.  
 *  @param {Element} btn_action Recebe o botão clicado.  
 */ 
    function btn_editar_experiencia(btn_action) {  
        var titulo = $('.des_titulo_experiencia', $(btn_action).parent().parent().parent());
        var descricao = $('.des_descricao_experiencia', $(btn_action).parent().parent().parent());
        var id_experiencia = $('.id_experiencia', $(btn_action).parent().parent().parent());
        
        $('#addExperienciaModal').modal();
        $('#id_experiencia_modal').val(id_experiencia.val());
        $('#des_titulo_experiencia').val(titulo.text());
        $('#des_descricao_experiencia').val(descricao.text());
    }

/** @description Executa a ação do botão deletar experiencia.  
 *  @param {Element} btn_action Recebe o botão clicado.  
 */ 
    function btn_deletar_experiencia(btn_action) {
        var id_experiencia = $('.id_experiencia', $(btn_action).parent().parent().parent());
        
        if (confirm('Realmente deseja deletar esta Experiencia?')){
            $(btn_action).parent().parent().parent().remove();
            $.post('controller/json_Usuario.php',
            {
                acao: 'del_experiencia',
                id_experiencia: $(id_experiencia).val()
            });
        }
    }

/** @description Apaga os valores dos campos do modal de Experiencia antes de exibi-lo.  
*/ 
    $('#addExperienciaModal').on('show.bs.modal', function (e) {
        $('#id_experiencia_modal').val('');
        $('#des_titulo_experiencia').val('');
        $('#des_descricao_experiencia').val('');
    });

/** @description Executa ação do botão de Adicionar Experiencia.  
 */ 
    $('#btn-addExperiencia').click(function(){

        if($('#id_experiencia_modal').val() != ''){
            var titulo = $('#des_titulo_experiencia');
            var descricao = $('#des_descricao_experiencia');
            var id_experiencia = $('#id_experiencia_modal');
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_experiencia',
                id_usuario: $('#id_usuario').val(),
                des_titulo: $(titulo).val(),
                des_descricao: $(descricao).val(),
                id_experiencia: $(id_experiencia).val()
            },
            function(data){
                $(".id_experiencia").each(function( index ) {
                    if($(this).val() == id_experiencia.val()){
                        var input = $( this );
                        $('.des_titulo_experiencia',$(input).parent()).text(titulo.val());
                        $('.des_descricao_experiencia',$(input).parent()).text(descricao.val());
                    }
                });
                $('#addExperienciaModal').modal('hide');
            });
        }else{
            var $id_usuario = $('#id_usuario_logado').val();
            var $titulo    = $('#des_titulo_experiencia').val();
            var $descr     = $('#des_descricao_experiencia').val();
            $.post('controller/json_Usuario.php',
            {
                acao        : 'ad_experiencia',
                id_usuario  : $id_usuario,
                titulo      : $titulo,
                descr       : $descr,
            },
            function(data){
                $('#experiencias-itens').prepend('<div class="col-12" style="margin-top:15px;margin-bottom:5px"><div class="clearfix"><input type="text" class="id_experiencia" value="'+data+'" style="display:none"><p class="des_titulo_experiencia" style="width:auto; margin-left:-5px;font-weight:400; padding-right:25px;font-size:17px;margin-bottom:0px">'+$titulo+'</p><p class="col-12 desc des_descricao_experiencia" style="margin-left:-10px;margin-right:-10px; padding-left:5px;padding-bottom:1px;padding-top:1px;font-weight:300;font-size:16px;">'+$descr+'</p><span class="clearfix pull-right" style="margin-top:-20px;padding:0px;margin:0px;font-weight:normal"><a class="btn-editExperiencia" style="color:blue;cursor:pointer;margin-right:10px">Editar</a><a class="btn-delExperiencia text-danger" style="cursor:pointer">Deletar</a></span></div></div>');
                $('.btn-editExperiencia').click(function(){
                    btn_editar_experiencia(this);
                });
                $('.btn-delExperiencia').click(function(){
                    btn_deletar_experiencia(this);
                });
                $('#addExperienciaModal').modal('hide');
            })
        }
        
    });


/* -------------------------------------------------------------------------------------------------
 *      SESSÃO FORMAÇÕES
 * ------------------------------------------------------------------------------------------------- */ 

/** @description Executa a ação do botão editar Formação.  
 *  @param {Element} btn_action Recebe o botão clicado.  
 */ 
    function btn_editar_formacao(btn_action) {  
        var titulo = $('.des_titulo_formacao', $(btn_action).parent().parent().parent());
        var descricao = $('.des_descricao_formacao', $(btn_action).parent().parent().parent());
        var id_formacao = $('.id_formacao', $(btn_action).parent().parent().parent());
        
        $('#addFormacaoModal').modal();
        $('#id_formacao_modal').val(id_formacao.val());
        $('#des_titulo_formacao').val(titulo.text());
        $('#des_descricao_formacao').val(descricao.text());
    }

 /** @description Executa a ação do botão deletar Formação.  
  *  @param {Element} btn_action Recebe o botão clicado.  
  */ 
    function btn_deletar_formacao(btn_action) {
        var id_formacao = $('.id_formacao', $(btn_action).parent().parent().parent());
        
        if (confirm('Realmente deseja deletar esta Formação?')){
            $(btn_action).parent().parent().parent().remove();
            $.post('controller/json_Usuario.php',
            {
                acao: 'del_formacao',
                id_formacao: $(id_formacao).val()
            });
        }
    }

/** @description Apaga os valores dos campos do modal de Formação antes de exibi-lo.  
 */ 
    $('#addFormacaoModal').on('show.bs.modal', function (e) {
        $('#id_formacao_modal').val('');
        $('#des_titulo_formacao').val('');
        $('#des_descricao_formacao').val('');
    });

/** @description Executa ação do botão de Adicionar Formação.  
 */ 
$('#btn-addFormacao').click(function(){
    if($('#id_formacao_modal').val() != ''){
        var titulo = $('#des_titulo_formacao');
        var descricao = $('#des_descricao_formacao');
        var id_formacao = $('#id_formacao_modal');
        $.post('controller/json_Usuario.php',
        {
            acao: 'up_formacao',
            id_usuario: $('#id_usuario').val(),
            des_titulo: $(titulo).val(),
            des_descricao: $(descricao).val(),
            id_formacao: $(id_formacao).val()
        },
        function(data){
            $(".id_formacao").each(function( index ) {
                if($(this).val() == id_formacao.val()){
                    var input = $( this );
                    $('.des_titulo_formacao',$(input).parent()).text(titulo.val());
                    $('.des_descricao_formacao',$(input).parent()).text(descricao.val());
                }
            });
            $('#addFormacaoModal').modal('hide');
        });
    }else{
        var $id_usuario = $('#id_usuario_logado').val();
        var $titulo    = $('#des_titulo_formacao').val();
        var $descr     = $('#des_descricao_formacao').val();
        $.post('controller/json_Usuario.php',
        {
            acao        : 'ad_formacao',
            id_usuario  : $id_usuario,
            titulo      : $titulo,
            descr       : $descr,
        },
        function(data){
            $('#formacoes-itens').prepend('<div class="col-12"><div class="clearfix"><input type="text" class="id_formacao" value="'+data+'" style="display:none"><p class="des_titulo_formacao" style="width:auto;margin-left:-5px;font-weight:400;font-size:17px;margin-bottom:0px;">'+$titulo+'</p><p class="desc des_descricao_formacao" id="des_apresentacao" style="margin-left:-5px;margin-right:-10px;margin-top:0px;font-weight:300">'+$descr+'</p><span class="clearfix pull-right" style="margin-top:-20px;padding:0px;margin:0px;font-weight:normal"><a class="btn-editFormacao" style="color:blue;cursor:pointer;margin-right:10px">Editar</a><a class="btn-delFormacao text-danger" style="cursor:pointer">Deletar</a></span></div></div>');
            $('.btn-editFormacao').click(function(){
                btn_editar_formacao(this);
            });
            $('.btn-delFormacao').click(function(){
                btn_deletar_formacao(this);
            });
            $('#addFormacaoModal').modal('hide');
        })
    }
    
});










































/* -------------------------------------------------------------------------------------------------
 *      SESSÃO SERVIÇOS
 * ------------------------------------------------------------------------------------------------- */ 

/** @description Executa a ação do botão editar Serviço.  
 *  @param {Element} btn_action Recebe o botão clicado.  
 */ 
function btn_editar_servico(btn_action) {  
    var categoria = $('.des_categoria_servico', $(btn_action).parent().parent().parent());
    var descricao = $('.des_descricao_servico', $(btn_action).parent().parent().parent());
    var preco = $('.des_preco_servico', $(btn_action).parent().parent().parent());
    var modalidade = $('.des_modalidade_servico', $(btn_action).parent().parent().parent());
    var disponibilidade = $('.des_disponibilidade_servico', $(btn_action).parent().parent().parent());
    var id_servico = $('.id_servico', $(btn_action).parent().parent().parent());
    
    $('#addServicoModal').modal();
    $('#des_categoria_servico').val(categoria.text());
    $('#des_descricao_servico').val(descricao.text());
    $('#des_preco_servico').val(preco.text());
    $('#des_modalidade_servico').val(modalidade.text());
    $('#des_disponibilidade_servico').val(disponibilidade.text());
    $('#id_servico_modal').val(id_servico.val());
}

/** @description Executa a ação do botão deletar Formação.  
*  @param {Element} btn_action Recebe o botão clicado.  
*/ 
function btn_deletar_formacao(btn_action) {
    // var id_formacao = $('.id_formacao', $(btn_action).parent().parent().parent());
    
    // if (confirm('Realmente deseja deletar esta Formação?')){
    //     $(btn_action).parent().parent().parent().remove();
    //     $.post('controller/json_Usuario.php',
    //     {
    //         acao: 'del_formacao',
    //         id_formacao: $(id_formacao).val()
    //     });
    // }
}

/** @description Apaga os valores dos campos do modal de Formação antes de exibi-lo.  
*/ 
$('#addServicoModal').on('show.bs.modal', function (e) {
    // $('#des_categoria_servico').val('');
    $('#des_descricao_servico').val('');
    $('#des_preco_servico').val('');
    // $('#des_modalidade_servico').val('');
    $('#des_disponibilidade_servico').val('');
    $('#id_servico_modal').val('');
});

/** @description Executa ação do botão de Adicionar Serviço.  
*/ 
$('#btn-addServico').click(function(){
if($('#id_servico_modal').val() != ''){
    var categoria = $('#des_categoria_servico');
    var descricao = $('#des_descricao_servico');
    var preco = $('#des_preco_servico');
    var modalidade = $('#des_modalidade_servico');
    var disponibilidade = $('#des_disponibilidade_servico');
    var id_servico = $('#id_servico_modal');
    $.post('controller/json_Usuario.php',
    {
        acao: 'up_servico',
        id_anuncio: $(id_servico).val(),
        id_categoria: $(categoria).val(),
        des_descricao: $(descricao).val(),
        des_preco: $(preco).val(),
        id_modalidade: $(modalidade).val(),
        des_disponibilidade: $(disponibilidade).val()
    },
    function(data){
        // alert(data);
        $(".id_servico").each(function( index ) {
            if($(this).val() == id_servico.val()){
                var input = $( this ); 
                $('.des_categoria_servico',$(input).parent()).text(categoria.val());
                $('.des_descricao_servico',$(input).parent()).text(descricao.val());
                $('.des_preco_servico',$(input).parent()).text(preco.val());
                $('.des_modalidade_servico',$(input).parent()).text(modalidade.val());
                $('.des_disponibilidade_servico',$(input).parent()).text(disponibilidade.val());
            }
        });
        $('#addServicoModal').modal('hide');
    });
}else{
    var categoria = $('#des_categoria_servico');
    var descricao = $('#des_descricao_servico');
    var preco = $('#des_preco_servico');
    var modalidade = $('#des_modalidade_servico');
    var disponibilidade = $('#des_disponibilidade_servico');
    var id_servico = $('#id_servico_modal');
    // $.post('controller/json_Usuario.php',
    // {
    //     acao        : 'ad_formacao',
    //     id_usuario  : $id_usuario,
    //     titulo      : $titulo,
    //     descr       : $descr,
    // },
    // function(data){
    //     $('#formacoes-itens').prepend('<div class="col-12"><div class="clearfix"><input type="text" class="id_formacao" value="'+data+'" style="display:none"><p class="des_titulo_formacao" style="width:auto;margin-left:-5px;font-weight:400;font-size:17px;margin-bottom:0px;">'+$titulo+'</p><p class="desc des_descricao_formacao" id="des_apresentacao" style="margin-left:-5px;margin-right:-10px;margin-top:0px;font-weight:300">'+$descr+'</p><span class="clearfix pull-right" style="margin-top:-20px;padding:0px;margin:0px;font-weight:normal"><a class="btn-editFormacao" style="color:blue;cursor:pointer;margin-right:10px">Editar</a><a class="btn-delFormacao text-danger" style="cursor:pointer">Deletar</a></span></div></div>');
    //     $('.btn-editFormacao').click(function(){
    //         btn_editar_formacao(this);
    //     });
    //     $('.btn-delFormacao').click(function(){
    //         btn_deletar_formacao(this);
    //     });
    //     $('#addFormacaoModal').modal('hide');
    // })
}

});








 

 













    





    


    

    // BOTAO DE EDITAR HABILIDADE
    // $('.btn-editHabilidade').click(function(){
        // var descricao = $('.des_descricao_habilidade', $(this).parent());
        // var id_habilidade = $('.id_habilidade', $(this).parent());

        // if($(descricao).hasClass('form-control-plaintext')){
        //     $(descricao).removeClass('form-control-plaintext');
        //     $(descricao).addClass('form-control');
        //     $(descricao).removeAttr('disabled');
        //     $(descricao).removeAttr('readonly');
        //     $(this).text("Salvar");
        // }else if($(descricao).hasClass('form-control')){
        //     $(descricao).removeClass('form-control');
        //     $(descricao).addClass('form-control-plaintext');
        //     $(descricao).attr('disabled','disabled');
        //     $(descricao).attr('readonly','readonly');
        //     $(this).text("Editar");
        //   }
    // });

    // BOTAO DE DELETAR HABILIDADE
    // $('.btn-delExperiencia').click(function(){
    //     var id_experiencia = $('.id_experiencia', $(this).parent());

    //     if (confirm('Realmente deseja deletar esta Experiencia?')){
    //         $(this).parent().parent().remove();
    //         $.post('controller/json_Usuario.php',
    //         {
    //             acao: 'del_experiencia',
    //             id_experiencia: $(id_experiencia).val()
    //         });
    //     }
    // });


   
















    // BOTÃO DE CRIAR NOVA CONEXAO
    $('#criar-conexao').click(function(){
        btn_criar_conexao_profile(this);
    });
    // BOTAO DE EDITAR EXPERIENCIA
    $('.btn-editExperiencia').click(function(){
        btn_editar_experiencia(this);
    });

    // BOTAO DE DELETAR EXPERIENCIA
    $('.btn-delExperiencia').click(function(){
        btn_deletar_experiencia(this);
    });

    // BOTAO DE EDITAR FORMACAO
    $('.btn-editFormacao').click(function(){
        btn_editar_formacao(this);
    });

    // BOTAO DE DELETAR FORMACAO
    $('.btn-delFormacao').click(function(){
        btn_deletar_formacao(this);
    });

    // BOTAO DE EDITAR SERVIÇO
    $('.btn-editServico').click(function(){
        btn_editar_servico(this);
    });
    


    /**
     * Função Responsável pela ação do botão Editar Apresentação
     */ 
    $('#btn-editApres').click(function(){
        var input = $('#des_apresentacao');
        var cancel = $('#btn-cancelEditApres');
        if($(input).hasClass('form-control-plaintext')){
            $(input).removeClass('form-control-plaintext');
            $(input).addClass('form-control');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');
            $(this).text("Salvar");
        }else if($(input).hasClass('form-control')){
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(cancel).addClass('d-none');
            $(this).text("Editar");
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_generico',
                campo: 'des_apresentacao',
                valor: $(input).val(),
                id: $('#id_usuario').val(),
            });
          }
    });
    /**
     * Função Responsável pela ação do botão Cancelar Edição Apresentação
     */ 
    $('#btn-cancelEditApres').click(function(){
        var input = $('#des_apresentacao');
        var edit = $('#btn-editApres');
        var cancel = $('#btn-cancelEditApres');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(edit).text("Editar");
            $('#form-apres')[0].reset();
            $(input).css('height','110px');            
        };
    });


































    // BOTAO DE EDITAR NOME COMPLETO
    $('#btn-editNome').click(function(){
        var input = $('#nomeUsr');
        var cancel = $('#btn-cancelEditNome');
        if($(input).hasClass('form-control-plaintext')){
            $(input).removeClass('form-control-plaintext');
            $(input).addClass('form-control');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');
            $(this).text("Salvar");
        }else if($(input).hasClass('form-control')){
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(cancel).addClass('d-none');
            $(this).text("Editar");
            var res = ($(input).val()).split(" ");
            $('#navbar-username').text(res[0]);
            $('.profile-name').text(res[0]+' '+res[res.length-1]);
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_generico',
                campo: 'des_nome',
                valor: $(input).val(),
                id: $('#id_usuario').val(),
            });
          }
    });

    // BOTAO DE CANCELAR EDIÇÃO DE NOME COMPLETO
    $('#btn-cancelEditNome').click(function(){
        var input = $('#nomeUsr');
        var edit = $('#btn-editNome');
        var cancel = $('#btn-cancelEditNome');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(edit).text("Editar");
        };
    });

    // BOTAO DE EDITAR OCUPACAO ATUAL
    $('#btn-editOcupacao').click(function(){
        var input = $('#ocupUsr');
        var cancel = $('#btn-cancelEditOcupacao');        
        if($(input).hasClass('form-control-plaintext')){
            $(input).removeClass('form-control-plaintext');
            $(input).addClass('form-control');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');
            $(this).text("Salvar");
        }else if($(input).hasClass('form-control')){
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $('#sideOcupacao').text($(input).val());
            $(cancel).addClass('d-none');
            $(this).text("Editar");
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_generico',
                campo: 'des_ocupacao',
                valor: $(input).val(),
                id: $('#id_usuario').val(),
            });
          }
    });

    // BOTAO DE CANCELAR EDIÇÃO DE OCUPACAO ATUAL
    $('#btn-cancelEditOcupacao').click(function(){
        var input = $('#ocupUsr');
        var edit = $('#btn-editOcupacao');
        var cancel = $('#btn-cancelEditOcupacao');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $('#sideOcupacao').text($(input).val());
            $(edit).text("Editar");
        };
    });

    // BOTAO DE EDITAR EMAIL
    $('#btn-editEmail').click(function(){
        var input = $('#emailUsr');
        var cancel = $('#btn-cancelEditEmail');        
        if($(input).hasClass('form-control-plaintext')){
            $(input).removeClass('form-control-plaintext');
            $(input).addClass('form-control');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');
            $(this).text("Salvar");
        }else if($(input).hasClass('form-control')){
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_email',
                email: $(input).val(),
                id: $('#id_usuario').val(),
            },
            function(data){
                if(data == 0){
                    $(input).css('border-color','red');
                    if(!$('#float-alert').length){
                        $('body').append('<div style="position:fixed;margin-top:75px;right:30px" id="float-alert" class="alert alert-danger alert-dismissible fade" role="alert"><strong id="text-float-alert">You should check in on some of those fields below.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    $('#text-float-alert').text('Email inválido ou já cadastrado!');
                    if($('#float-alert').hasClass('alert-success')){
                        $('#float-alert').removeClass('alert-success');
                        $('#float-alert').addClass('alert-danger');
                    }
                    if(!$('#float-alert').hasClass('show')){
                        $('#float-alert').addClass('show');
                    }
                    $(input).focus();
                }else{
                    if(!$('#float-alert').length){
                        $('body').append('<div style="position:fixed;margin-top:75px;right:30px" id="float-alert" class="alert alert-success alert-dismissible fade" role="alert"><strong id="text-float-alert">You should check in on some of those fields below.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    }
                    $('#text-float-alert').text('Email alterado com sucesso!');
                    if($('#float-alert').hasClass('alert-danger')){
                        $('#float-alert').removeClass('alert-danger');
                        $('#float-alert').addClass('alert-success');
                    }
                    if(!$('#float-alert').hasClass('show')){
                        $('#float-alert').addClass('show');
                    }
                    $(input).removeClass('form-control');
                    $(input).addClass('form-control-plaintext');
                    $(input).attr('disabled','disabled');
                    $(input).attr('readonly','readonly');
                    $(input).css('border-color','');
                    $(cancel).addClass('d-none');                    
                    $('#btn-editEmail').text("Editar");
                }
            });
          }
    });

    // BOTAO DE CANCELAR EDIÇÃO DE EMAIL
    $('#btn-cancelEditEmail').click(function(){
        var input = $('#emailUsr');
        var edit = $('#btn-editEmail');
        var cancel = $('#btn-cancelEditEmail');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(edit).text("Editar");
        };
    });

    // BOTAO DE EDITAR TELEFONE/CELULAR
    $('#btn-editTel').click(function(){
        var input = $('#telUsr');
        var cancel = $('#btn-cancelEditTel');        
        if($(input).hasClass('form-control-plaintext')){
            $(input).removeClass('form-control-plaintext');
            $(input).addClass('form-control');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');            
            $(this).text("Salvar");
        }else if($(input).hasClass('form-control')){
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(cancel).addClass('d-none');            
            $(this).text("Editar");
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_generico',
                campo: 'des_telefone',
                valor: $(input).val(),
                id: $('#id_usuario').val(),
            });
          }
    });

    // BOTAO DE CANCELAR EDIÇÃO DE TELEFONE/CELULAR
    $('#btn-cancelEditTel').click(function(){
        var input = $('#telUsr');
        var edit = $('#btn-editTel');
        var cancel = $('#btn-cancelEditTel');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(edit).text("Editar");
        };
    });

    // BOTAO DE EDITAR CPF
    $('#btn-editCpf').click(function(){
        var input = $('#cpfUsr');
        var cancel = $('#btn-cancelEditCpf');        
        if($(input).hasClass('form-control-plaintext')){
            $(input).removeClass('form-control-plaintext');
            $(input).addClass('form-control');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');
            $(this).text("Salvar");
        }else if($(input).hasClass('form-control')){
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(cancel).addClass('d-none');            
            $(this).text("Editar");
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_generico',
                campo: 'des_cpf',
                valor: $(input).val(),
                id: $('#id_usuario').val(),
            });
          }
    });

    // BOTAO DE CANCELAR EDIÇÃO DE CPF
    $('#btn-cancelEditCpf').click(function(){
        var input = $('#cpfUsr');
        var edit = $('#btn-editCpf');
        var cancel = $('#btn-cancelEditCpf');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(edit).text("Editar");
        };
    });

    // BOTAO DE EDITAR DATA DE NASCIMENTO
    $('#btn-editDtNasc').click(function(){
        var input = $('#dtNascUsr');
        var cancel = $('#btn-cancelEditDtNasc');        
        if($(input).hasClass('form-control-plaintext')){
            $(input).removeClass('form-control-plaintext');
            $(input).addClass('form-control');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');            
            $(this).text("Salvar");
        }else if($(input).hasClass('form-control')){
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(cancel).addClass('d-none');            
            $(this).text("Editar");
            $('#sideIdade').text(calcularIdade($(input).val())+' anos');
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_generico',
                campo: 'dt_nasc',
                valor: $(input).val(),
                id: $('#id_usuario').val(),
            });
          }
    });

    // BOTAO DE CANCELAR EDIÇÃO DE DATA DE NASCIMENTO
    $('#btn-cancelEditDtNasc').click(function(){
        var input = $('#dtNascUsr');
        var edit = $('#btn-editDtNasc');
        var cancel = $('#btn-cancelEditDtNasc');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $('#sideIdade').text(calcularIdade($(input).val()));
            $(edit).text("Editar");
        };
    });

    // BOTAO DE EDITAR SEXO
    $('#btn-editSexo').click(function(){
        var input = $('#sexoUsr');
        var cancel = $('#btn-cancelEditSexo');        
        if($(input).hasClass('form-control-plaintext')){
            $(input).removeClass('form-control-plaintext');
            $(input).addClass('form-control');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');            
            $(this).text("Salvar");
        }else if($(input).hasClass('form-control')){
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            if($('#sideSexo').text() != null){
                if(($(input).val() == 'M')||($(input).val() == 'Masculino')){
                    $('#sideSexo').text('Masculino, ');
                }else if(($(input).val() == 'F')||($(input).val() == 'Feminino')){
                    $('#sideSexo').text('Feminino, ');
                }else{
                    $('#sideSexo').text('');
                }
            }
            $(cancel).addClass('d-none');            
            $(this).text("Editar");
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_generico',
                campo: 'des_sexo',
                valor: $(input).val(),
                id: $('#id_usuario').val(),
            });
          }
    });

    // BOTAO DE CANCELAR EDIÇÃO DE SEXO
    $('#btn-cancelEditSexo').click(function(){
        var input = $('#sexoUsr');
        var edit = $('#btn-editSexo');
        var cancel = $('#btn-cancelEditSexo');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            if($('#sideSexo').text() != null){
                if(($(input).val() == 'M')||($(input).val() == 'Masculino')){
                    $('#sideSexo').text('Masculino, ');
                }else if(($(input).val() == 'F')||($(input).val() == 'Feminino')){
                    $('#sideSexo').text('Feminino, ');
                }else{
                    $('#sideSexo').text('');
                }
            }
            $(edit).text("Editar");
        };
    });

    // BOTAO DE EDITAR SLUG
    $('#btn-editSlug').click(function(){
        var input = $('#slugUsr');
        var cancel = $('#btn-cancelEditSlug');    
        if($(input).hasClass('block-plaintext')){  
            atual_slug = $(input).val();  
            $(input).removeClass('block-plaintext');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');            
            $(this).text("Salvar");
        }else if(!$(input).hasClass('block-plaintext')){
            $(input).addClass('block-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(cancel).addClass('d-none');            
            $(this).text("Editar");
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_slug',
                slug: $(input).val(),
                id: $('#id_usuario').val(),
            },
            function(data){
                if(data == 1){
                    alert('Usuário atualizado com sucesso!');
                    setTimeout(function(){window.location.href = $(input).val();} , 500);
                }else{
                    $(input).val(atual_slug);
                    alert('Usuário já existe!');
                }
            });
        }
    });

    // BOTAO DE CANCELAR EDIÇÃO DE SLUG
    $('#btn-cancelEditSlug').click(function(){
        var input = $('#slugUsr');
        var edit = $('#btn-editSlug');
        var cancel = $('#btn-cancelEditSlug');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).addClass('block-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(edit).text("Editar");
        };
    });


    // BOTAO DE EDITAR CIDADE
    $('#btn-editCidade').click(function(){
        var input = $('#cidadeUsr');
        var cancel = $('#btn-cancelEditCidade');        
        if($(input).hasClass('form-control-plaintext')){
            $(input).removeClass('form-control-plaintext');
            $(input).addClass('form-control');
            $(input).removeAttr('disabled');
            $(input).removeAttr('readonly');
            $(cancel).removeClass('d-none');            
            $(this).text("Salvar");
        }else if($(input).hasClass('form-control')){
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(cancel).addClass('d-none');            
            $(this).text("Editar");
            // $.post('controller/json_Usuario.php',
            // {
            //     acao: 'up_generico',
            //     campo: 'dt_nasc',
            //     valor: $(input).val(),
            //     id: $('#id_usuario').val(),
            // });
          }
    });

    // BOTAO DE CANCELAR EDIÇÃO DE CIDADE
    $('#btn-cancelEditCidade').click(function(){
        var input = $('#cidadeUsr');
        var edit = $('#btn-editCidade');
        var cancel = $('#btn-cancelEditCidade');
        if(!$(cancel).hasClass('d-none')){
            $(cancel).addClass('d-none');
            $(input).removeClass('form-control');
            $(input).addClass('form-control-plaintext');
            $(input).attr('disabled','disabled');
            $(input).attr('readonly','readonly');
            $(edit).text("Editar");
        };
    });
});




















