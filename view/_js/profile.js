
$(document).ready(function () {
    
    $("#usrFotoView").click(function (e) {
        $('#usrFoto').click(); // Open dialog
        e.preventDefault();
    });
    $("#fotoMouseOn").click(function (e) {
        $('#usrFoto').click(); // Open dialog
        e.preventDefault();
    });

    $("#fotoMouseOn").mouseover(function() {
        $("#fotoMouseOn").css('display','block');
    });
    $("#fotoMouseOn").mouseout(function() {
        $("#fotoMouseOn").css('display','none');
    });

    $("#usrFotoView").mouseover(function() {
        $("#fotoMouseOn").css('display','block');
    });
    
    $("#usrFoto").change(function(){
        $('#form-usrFoto').submit();        
    });


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

    /**
     * Função Responsável por fazer o update da foto do usuário via AJAX
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

    function btn_criar_conexao_profile(btn_action){
        if($(btn_action).hasClass('btn-primary')){
            $(btn_action).text('Remover Contato');
            $(btn_action).removeClass('btn-primary');
            $(btn_action).addClass('btn-danger');

            $.post('controller/json_Usuario.php',
            {
                acao: 'ad_conexao',
                id_usuario: $('#id_usuario_logado').val(),
                id_contato: $('#id_usuario').val(),
            });
        }else{
            $(btn_action).text('Adicionar Contato');
            $(btn_action).removeClass('btn-danger');
            $(btn_action).addClass('btn-primary');
            $.post('controller/json_Usuario.php',
            {
                acao: 'rem_conexao',
                id_usuario: $('#id_usuario_logado').val(),
                id_contato: $('#id_usuario').val(),
            });
        }
    }

    /**
     * Função Responsável pela ação do botão Editar Experiencias
     */  
    function btn_editar_experiencia(btn_action) {  
        var titulo = $('.des_titulo_experiencia', $(btn_action).parent());
        var descricao = $('.des_descricao_experiencia', $(btn_action).parent());
        var id_experiencia = $('.id_experiencia', $(btn_action).parent());
        var btn_cancelar = $('.btn-delExperiencia', $(btn_action).parent());
        if($(titulo).hasClass('form-control-plaintext')){
            $(titulo).removeClass('form-control-plaintext');
            $(titulo).addClass('form-control');
            $(titulo).removeAttr('disabled');
            $(titulo).removeAttr('readonly');
            $(descricao).removeClass('form-control-plaintext');
            $(descricao).addClass('form-control');
            $(descricao).removeAttr('disabled');
            $(descricao).removeAttr('readonly');
            $(btn_action).text("Salvar");
            $(btn_cancelar).text('Cancelar');
        }else if($(titulo).hasClass('form-control')){
            $(titulo).removeClass('form-control');
            $(titulo).addClass('form-control-plaintext');
            $(titulo).attr('disabled','disabled');
            $(titulo).attr('readonly','readonly');
            $(descricao).removeClass('form-control');
            $(descricao).addClass('form-control-plaintext');
            $(descricao).attr('disabled','disabled');
            $(descricao).attr('readonly','readonly');
            $(btn_action).text("Editar");
            $(btn_cancelar).text('Deletar');
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_experiencia',
                id_usuario: $('#id_usuario').val(),
                des_titulo: $(titulo).val(),
                des_descricao: $(descricao).val(),
                id_experiencia: $(id_experiencia).val()
            });
        }
    }

    /**
     * Função Responsável pela ação do botão Remover Experiencias
     */ 
    function btn_deletar_experiencia(btn_action) {
        var titulo = $('.des_titulo_experiencia', $(btn_action).parent());
        var descricao = $('.des_descricao_experiencia', $(btn_action).parent());
        var id_experiencia = $('.id_experiencia', $(btn_action).parent());
        var btn_salvar = $('.btn-editExperiencia', $(btn_action).parent());
        
        if($(btn_action).text() == 'Cancelar'){
            $(titulo).removeClass('form-control');
            $(titulo).addClass('form-control-plaintext');
            $(titulo).attr('disabled','disabled');
            $(titulo).attr('readonly','readonly');
            $(descricao).removeClass('form-control');
            $(descricao).addClass('form-control-plaintext');
            $(descricao).attr('disabled','disabled');
            $(descricao).attr('readonly','readonly');
            $(btn_salvar).text("Editar");
            $(btn_action).text('Deletar');
        }else{
            if (confirm('Realmente deseja deletar esta Experiencia?')){
                $(btn_action).parent().parent().remove();
                $.post('controller/json_Usuario.php',
                {
                    acao: 'del_experiencia',
                    id_experiencia: $(id_experiencia).val()
                });
            }
        }
    }

    /**
     * Função Responsável pela ação do botão Editar Formações
     */ 
    function btn_editar_formacao(btn_action) {
        var titulo = $('.des_titulo_formacao', $(btn_action).parent());
        var descricao = $('.des_descricao_formacao', $(btn_action).parent());
        var id_formacao = $('.id_formacao', $(btn_action).parent());
        var btn_cancelar = $('.btn-delFormacao', $(btn_action).parent());

        if($(titulo).hasClass('form-control-plaintext')){
            $(titulo).removeClass('form-control-plaintext');
            $(titulo).addClass('form-control');
            $(titulo).removeAttr('disabled');
            $(titulo).removeAttr('readonly');
            $(descricao).removeClass('form-control-plaintext');
            $(descricao).addClass('form-control');
            $(descricao).removeAttr('disabled');
            $(descricao).removeAttr('readonly');
            $(btn_action).text("Salvar");
            $(btn_cancelar).text('Cancelar');
        }else if($(titulo).hasClass('form-control')){
            $(titulo).removeClass('form-control');
            $(titulo).addClass('form-control-plaintext');
            $(titulo).attr('disabled','disabled');
            $(titulo).attr('readonly','readonly');
            $(descricao).removeClass('form-control');
            $(descricao).addClass('form-control-plaintext');
            $(descricao).attr('disabled','disabled');
            $(descricao).attr('readonly','readonly');
            $(btn_action).text("Editar");
            $(btn_cancelar).text('Deletar');
            $.post('controller/json_Usuario.php',
            {
                acao: 'up_formacao',
                id_usuario: $('#id_usuario').val(),
                des_titulo: $(titulo).val(),
                des_descricao: $(descricao).val(),
                id_formacao: $(id_formacao).val()
            });
        }
    }

    /**
     * Função Responsável pela ação do botão Remover Formações
     */ 
    function btn_deletar_formacao(btn_action) {
        var titulo = $('.des_titulo_formacao', $(btn_action).parent());
        var descricao = $('.des_descricao_formacao', $(btn_action).parent());
        var btn_salvar = $('.btn-editFormacao', $(btn_action).parent());
        var id_formacao = $('.id_formacao', $(btn_action).parent());
        if($(btn_action).text() == 'Cancelar'){
            $(titulo).removeClass('form-control');
            $(titulo).addClass('form-control-plaintext');
            $(titulo).attr('disabled','disabled');
            $(titulo).attr('readonly','readonly');
            $(descricao).removeClass('form-control');
            $(descricao).addClass('form-control-plaintext');
            $(descricao).attr('disabled','disabled');
            $(descricao).attr('readonly','readonly');
            $(btn_salvar).text("Editar");
            $(btn_action).text('Deletar');
        }else{
            if (confirm('Realmente deseja deletar esta Formação?')){
                $(btn_action).parent().parent().remove();
                $.post('controller/json_Usuario.php',
                {
                    acao: 'del_formacao',
                    id_formacao: $(id_formacao).val()
                });
            }
        }
    }













    





    


    

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


    // BOTÃO DE ADICIONAR FORMAÇÃO
    $('#btn-addFormacao').click(function(){
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
            $('#addFormacaoModal').modal('hide');
            $('#formacoes-itens').before('<div class="col-12" style="margin-top:15px;margin-bottom:15px"><div class="clearfix"><input type="text" class="id_formacao" value="'+data+'" style="display:none"><input type="text" class="form-control-plaintext des_titulo_formacao pull-left col-8" readonly disabled value="'+$titulo+'" style="height:auto;resize: none;margin-left:-10px;font-weight:bold;text-transform:uppercase; padding-left:5px;margin-right:-10px;font-size:15px"><button type="button" class="btn pull-left btn-editFormacao btn-link" style="margin-top:0px;margin-left:20px">Editar</button><button type="button" class="btn pull-left btn-delFormacao btn-link" style="color: red;margin-top:0px;margin-left:0px">Deletar</button><textarea class="desc des_descricao_formacao form-control-plaintext" readonly disabled name="des_apresentacao" id="des_apresentacao" rows="1" cols="30" style="height:auto;resize: none;margin-left:-10px;margin-right:-10px; padding-left:5px; padding-top:0px;" spellcheck="false">'+$descr+'</textarea></div></div>');
            $('.btn-editFormacao').click(function(){
                btn_editar_formacao(this);
            });
            $('.btn-delFormacao').click(function(){
                btn_deletar_formacao(this);
            });
        })
    });


    // BOTÃO DE ADICIONAR EXPERIÊNCIA
    $('#btn-addExperiencia').click(function(){
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
            $('#addExperienciaModal').modal('hide');
            $('#experiencias-itens').before('<div class="col-12" style="margin-top:15px;margin-bottom:15px"><div class="clearfix"><input type="text" class="id_experiencia" value="'+data+'" style="display:none"><input type="text" class="form-control-plaintext des_titulo_experiencia pull-left col-md-8" readonly disabled value="'+$titulo+'" style="height:auto;resize: none;margin-left:-10px;font-weight:bold;text-transform:uppercase; padding-left:5px;margin-right:-10px;font-size:15px;"><button type="button" id="btn-cancelEditExperiencia" class="pull-left btn btn-link d-none text-danger">Cancelar</button><button type="button" class="btn pull-left btn-editExperiencia btn-link">Editar</button><button type="button" class="btn pull-left btn-delExperiencia btn-link text-danger" style="margin-top:0px">Deletar</button><textarea class="desc des_descricao_experiencia form-control-plaintext" readonly disabled name="des_apresentacao" id="des_apresentacao" cols="30" style="height:auto;resize: none;margin-left:-10px;margin-right:-10px; padding-left:5px;" spellcheck="false">'+$descr+'</textarea></div></div>');
            $('.btn-editExperiencia').click(function(){
                btn_editar_experiencia(this);
            });
            $('.btn-delExperiencia').click(function(){
                btn_deletar_experiencia(this);
            });
        })
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
                        $('body').append('<div id="float-alert" class="alert alert-danger alert-dismissible fade" role="alert"><strong id="text-float-alert">You should check in on some of those fields below.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
                        $('body').append('<div id="float-alert" class="alert alert-success alert-dismissible fade" role="alert"><strong id="text-float-alert">You should check in on some of those fields below.</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
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
                acao: 'up_generico',
                campo: 'des_slug',
                valor: $(input).val(),
                id: $('#id_usuario').val(),
                success: function(data){
                    setTimeout(function(){window.location.href = $(input).val();} , 500);
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
