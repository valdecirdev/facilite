
$(document).ready(function () {
   
/* -------------------------------------------------------------------------------------------------
 *      FUNÇÕES GERAIS
 * ------------------------------------------------------------------------------------------------- */ 
   
/** @description Calcula a idade do usuario com base na data de nascimento informada ;
 *  @param {number} nascimento Data de nascimento do usuário
 *  @return {number} Idade do usuário 
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
                url: "app/view/_utils/ajax_perfil.php", // Url do lado server que vai receber o arquivo
                data: form,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (data) {
                    $('.img-nav-dropdown').attr('src, view/+img/profile/'+data);
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
            $('#msg-btnContato').text('Remover');
            $(btn_action).removeClass('btn-fc-primary');
            $(btn_action).addClass('btn-fc-danger');

            $.post('app/view/_utils/ajax_perfil.php',
            {
                acao: 'ad_conexao',
                id_usuario: $('#id_usuario_logado').val(),
                id_contato: $('#id_usuario').val(),
            });
        }else{
            $('#msg-btnContato').text('Adicionar');
            $(btn_action).removeClass('btn-fc-danger');
            $(btn_action).addClass('btn-fc-primary');
            $.post('app/view/_utils/ajax_perfil.php',
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
        var titulo = $('.des_titulo_experiencia', $(btn_action).parent().parent().parent().parent());
        var descricao = $('.des_descricao_experiencia', $(btn_action).parent().parent().parent().parent());
        var id_experiencia = $('.id_experiencia', $(btn_action).parent().parent().parent().parent());
        
        $('#addExperienciaModal').modal();
        $('#id_experiencia_modal').val(id_experiencia.val());
        $('#des_titulo_experiencia').val(titulo.text());
        $('#des_descricao_experiencia').val(descricao.text());
    }

/** @description Executa a ação do botão deletar experiencia.  
 *  @param {Element} btn_action Recebe o botão clicado.  
 */ 
    function btn_deletar_experiencia(btn_action) {
        var id_experiencia = $('.id_experiencia', $(btn_action).parent().parent().parent().parent());
        
        if (confirm('Realmente deseja deletar esta Experiencia?')){
            $(btn_action).parent().parent().parent().parent().parent().remove();
            $.post('app/view/_utils/ajax_perfil.php',
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
            $.post('app/view/_utils/ajax_perfil.php',
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
            $.post('app/view/_utils/ajax_perfil.php',
            {
                acao        : 'ad_experiencia',
                id_usuario  : $id_usuario,
                titulo      : $titulo,
                descr       : $descr,
            },
            function(data){
                $('#experiencias-itens').prepend('<div class="col-12" style="margin-top:15px;margin-bottom:5px"><div class="clearfix"><input type="text" class="id_experiencia" value="'+data+'" style="display:none"><div class="row clearfix"><p class="des_titulo_experiencia col-11" style="width:auto; margin-left:-5px;font-weight:400; padding-right:25px;font-size:17px;margin-bottom:0px">'+$titulo+'</p><div class="btn-group col-1"><button type="button" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button><div class="dropdown-menu dropdown-menu-right"><button class="btn-editExperiencia dropdown-item" type="button" style="cursor:pointer">Editar</button><button class="btn-delExperiencia text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button></div></div></div><p class="col-12 desc des_descricao_experiencia" style="margin-left:-10px;margin-right:-10px; padding-left:5px;padding-bottom:1px;padding-top:1px;font-weight:300;font-size:16px;color:#a0a5b5">'+$descr+'</p></div><hr style="margin-left:-15px;margin-right:-15px"></div>');
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
        var titulo = $('.des_titulo_formacao', $(btn_action).parent().parent().parent().parent());
        var descricao = $('.des_descricao_formacao', $(btn_action).parent().parent().parent().parent());
        var id_formacao = $('.id_formacao', $(btn_action).parent().parent().parent().parent());
        
        $('#addFormacaoModal').modal();
        $('#id_formacao_modal').val(id_formacao.val());
        $('#des_titulo_formacao').val(titulo.text());
        $('#des_descricao_formacao').val(descricao.text());
    }

 /** @description Executa a ação do botão deletar Formação.  
  *  @param {Element} btn_action Recebe o botão clicado.  
  */ 
    function btn_deletar_formacao(btn_action) {
        var id_formacao = $('.id_formacao', $(btn_action).parent().parent().parent().parent());
        
        if (confirm('Realmente deseja deletar esta Formação?')){
            $(btn_action).parent().parent().parent().parent().parent().remove();
            $.post('app/view/_utils/ajax_perfil.php',
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
        $.post('app/view/_utils/ajax_perfil.php',
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
        $.post('app/view/_utils/ajax_perfil.php',
        {
            acao        : 'ad_formacao',
            id_usuario  : $id_usuario,
            titulo      : $titulo,
            descr       : $descr,
        },
        function(data){
            $('#formacoes-itens').prepend('<div class="col-12"><div class="clearfix"><input type="text" class="id_formacao" value="'+data+'" style="display:none"><div class="row clearfix"><p class="des_titulo_formacao col-11" style="width:auto;margin-left:-5px;font-weight:400;font-size:17px;margin-bottom:0px;">'+$titulo+'</p><div class="btn-group col-1"><button type="button" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button><div class="dropdown-menu dropdown-menu-right"><button class="btn-editFormacao dropdown-item" type="button" style="cursor:pointer">Editar</button><button class="btn-delFormacao text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button></div></div></div><p class="desc des_descricao_formacao" id="des_apresentacao" style="margin-left:-5px;margin-right:-10px;margin-top:0px;font-weight:300;color:#a0a5b5">'+$descr+'</p></div><hr style="margin-left:-15px;margin-right:-15px"></div>');
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
    var categoria = $('.des_categoria_servico', $(btn_action).parent().parent().parent().parent());
    var descricao = $('.des_descricao_servico', $(btn_action).parent().parent().parent().parent());
    var preco = $('.des_preco_servico', $(btn_action).parent().parent().parent().parent());
    var modalidade = $('.des_modalidade_servico', $(btn_action).parent().parent().parent().parent());
    var disponibilidade = $('.des_disponibilidade_servico', $(btn_action).parent().parent().parent().parent());
    var id_servico = $('.id_servico', $(btn_action).parent().parent().parent().parent());
    
    $('#addServicoModal').modal();
    $('#des_categoria_servico').val(categoria.attr('id'));
    $('#des_descricao_servico').val(descricao.text());
    $('#des_preco_servico').val(preco.text());
    $('#des_modalidade_servico').val(modalidade.attr('id'));
    $('#des_disponibilidade_servico').val(disponibilidade.text());
    $('#id_servico_modal').val(id_servico.val());
}

/** @description Executa a ação do botão deletar Formação.  
*  @param {Element} btn_action Recebe o botão clicado.  
*/ 
function btn_deletar_servico(btn_action) {
    var id_servico = $('.id_servico', $(btn_action).parent().parent().parent().parent());
    if (confirm('Realmente deseja deletar este Serviço?')){
        $(btn_action).parent().parent().parent().parent().remove();
        $.post('app/view/_utils/ajax_perfil.php',
        {
            acao: 'del_servico',
            id_servico: id_servico.val()
        });
    }
}

/** @description Apaga os valores dos campos do modal de Formação antes de exibi-lo.  
*/ 
$('#addServicoModal').on('show.bs.modal', function (e) {
    $('#des_descricao_servico').val('');
    $('#des_preco_servico').val('');
    $('#des_disponibilidade_servico').val('');
    $('#id_servico_modal').val('');
});

/** @description Executa ação do botão de Adicionar Serviço.  
*/
$('#btn-addServico').click(function(){
if(($('#id_servico_modal').val() != '')&&($('#id_servico_modal').val() != undefined)){
    var categoria = $('#des_categoria_servico');
    var descricao = $('#des_descricao_servico');
    var preco = $('#des_preco_servico');
    var modalidade = $('#des_modalidade_servico');
    var disponibilidade = $('#des_disponibilidade_servico');
    var id_servico = $('#id_servico_modal');
    $.post('app/view/_utils/ajax_perfil.php',
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
        var categoria = $('#des_categoria_servico option:selected');
        var modalidade = $('#des_modalidade_servico option:selected');
        $(".id_servico").each(function( index ) {
            if($(this).val() == id_servico.val()){
                var input = $( this ); 
                $('.des_categoria_servico',$(input).parent()).text(categoria.text());
                $('.des_categoria_servico',$(input).parent()).attr('id',categoria.val());
                $('.des_descricao_servico',$(input).parent()).text(descricao.val());
                $('.des_preco_servico',$(input).parent()).text(preco.val());
                $('.des_modalidade_servico',$(input).parent()).text(' '+modalidade.text());
                $('.des_modalidade_servico',$(input).parent()).attr('id',modalidade.val());
                $('.des_disponibilidade_servico',$(input).parent()).text(disponibilidade.val());
            }
        });
        $('#addServicoModal').modal('hide');
    });
}else{
    var categoria = $('#des_categoria_servico');
    // var categ =  $('#des_categoria_servico optionoption:selected').text();
    var descricao = $('#des_descricao_servico');
    var preco = $('#des_preco_servico');
    var modalidade = $('#des_modalidade_servico');
    var disponibilidade = $('#des_disponibilidade_servico');
    var id_usuario = $('#id_usuario');

    $.post('app/view/_utils/ajax_perfil.php',
    {
        acao: 'add_servico',
        id_usuario: $(id_usuario).val(),
        id_categoria: $(categoria).val(),
        des_descricao: $(descricao).val(),
        des_preco: $(preco).val(),
        id_modalidade: $(modalidade).val(),
        des_disponibilidade: $(disponibilidade).val()
    },
    function(data){
        var categoria = $('#des_categoria_servico option:selected');
        var modalidade = $('#des_modalidade_servico option:selected');
        $('#servicos-itens').append('<div class="col-12 clearfix" style="margin-bottom:5px"><input type="text" class="d-none id_servico" value="'+data+'"><div class="row clearfix"><p class="des_categoria_servico col-11" id="'+categoria.val()+'" style="width:auto; margin-left:-5px;font-weight:400; padding-right:25px;font-size:17px;margin-bottom:0px">'+categoria.text()+'</p><div class="btn-group col-1"><button type="button" class="btn btn-link dropdown-toggle" style="color:#5b5656" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button><div class="dropdown-menu dropdown-menu-right"><button class="btn-editServico dropdown-item" type="button" style="cursor:pointer">Editar</button><button class="btn-delServico text-danger dropdown-item" type="button" style="cursor:pointer">Deletar</button></div></div></div><p class="col-12 desc des_descricao_servico" style="margin-left:-10px;margin-right:-10px; padding-left:5px;padding-bottom:1px;padding-top:10px;font-weight:300;font-size:16px;">'+descricao.val()+'</p><p class="desc" style="margin-left:-5px">Preço: R$ <span class="des_preco_servico">'+preco.val()+'</span><span class="des_modalidade_servico" id="<?php echo $modalidade->getIdModalidade(); ?>" style="margin-right:15px">'+' '+modalidade.text()+'</span>Disponibilidade: <span class="des_disponibilidade_servico">'+disponibilidade.val()+'</span></p><hr style="margin-left:-15px;margin-right:-15px"></div>');
        $('.btn-editServico').click(function(){
            btn_editar_servico(this);
        });
        $('.btn-delServico').click(function(){
            btn_deletar_servico(this);
        });
        $('#addServicoModal').modal('hide');
    })
}

});



/* -------------------------------------------------------------------------------------------------
 *      SESSÃO HABILIDADES
 * ------------------------------------------------------------------------------------------------- */ 
    //LIMPA MODAL ADD HABILIDADE
    $('#addHabilidadeModal').on('show.bs.modal', function (e) {
        $('#des_habilidade_modal').val(1);
    });
    // BOTAO DE SALVAR HABILIDADE
    $('#btn-addHabilidade').click(function(){
        var descricao = $('#des_habilidade_modal option:selected').text();
        var id_habilidade = $('#des_habilidade_modal').val();
        var id_usuario = $('#id_usuario').val();
        
        $.post('app/view/_utils/ajax_perfil.php',
        {
            acao: 'add_habilidade',
            id_usuario: id_usuario,
            id_habilidade: id_habilidade
        },function(data){
            if((data == 1)||(data == true)){
                $('#habilidades-itens').append('<span id="'+id_habilidade+'" class="skills-label">'+descricao+'<i class="fa fa-times-circle btn-delHabilidade" style="margin-left:10px;cursor:pointer"></i></span>');
                $('.btn-delHabilidade').click(function(){
                    var id_usuario = $('#id_usuario').val();
                    var id_habilidade = $(this).parent().attr('id');
                    
                    if (confirm('Realmente deseja deletar esta Habilidade?')){
                        $(this).parent().remove();
                        $.post('app/view/_utils/ajax_perfil.php',
                        {
                            acao: 'del_habilidade',
                            id_usuario: id_usuario,
                            id_habilidade: id_habilidade
                        });
                    }
                });
            }else{
                alert('Você já possui esta Habilidade!');
            }
        });
        $('#addHabilidadeModal').modal('hide');
    });

    // BOTAO DE DELETAR HABILIDADE
    $('.btn-delHabilidade').click(function(){
        var id_usuario = $('#id_usuario').val();
        var id_habilidade = $(this).parent().attr('id');
        
        if (confirm('Realmente deseja deletar esta Habilidade?')){
            $(this).parent().remove();
            $.post('app/view/_utils/ajax_perfil.php',
            {
                acao: 'del_habilidade',
                id_usuario: id_usuario,
                id_habilidade: id_habilidade
            });
        }
    });



/* -------------------------------------------------------------------------------------------------
 *      SESSÃO SOBRE
 * ------------------------------------------------------------------------------------------------- */ 
    //CARREGA MODAL SOBRE
    $('#editApresentacaoModal').on('show.bs.modal', function (e) {
        $('#des_apresentacao_modal').val($('#des_apresentacao').text());
    });
    // BOTAO DE SALVAR APRENSENTACAO
    $('#btn-editApresentacao').click(function(){
        var apresentacao = $('#des_apresentacao_modal').val();
        
        $.post('app/view/_utils/ajax_perfil.php',
        {
            acao:   'up_generico',
            campo:  'des_apresentacao',
            valor:  apresentacao,
            id:     $('#id_usuario').val(),
        },function(data){
            if(apresentacao != ''){
                $('#des_apresentacao').text(apresentacao);
            }else{
                $('#des_apresentacao').text('Olá, eu sou novo aqui. :)');
            }
            $('#editApresentacaoModal').modal('hide');
        });
    });




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

    // BOTAO DE DELETAR SERVIÇO
    $('.btn-delServico').click(function(){
        btn_deletar_servico(this);
    });
});