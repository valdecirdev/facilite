// import VueTheMask from 'vue-the-mask.js'

var app = new Vue({
    el: '#content',
    data: {
        senha: null,
        confirmSenha: null,
        user: usuario,
        cidades: null,
    },
    methods: {

    // ---------------------------------------------------------------------------
    //          METODOS DAS INFORMACOES BASICAS
    // ---------------------------------------------------------------------------
        
        salvarUsuario: function(e){
            if(!this.user.des_slug){
                $('.basic-msg').text('O campo "Nome de usuário" não pode estar vazio!');
                if($('.basic-msg').hasClass('d-none')){
                    $('.basic-msg').addClass('text-danger');
                    $('.basic-msg').removeClass('d-none');
                }
            }else{
                $.post('_utils/ajax_perfil.php',
                {
                    acao    : 'up_slug',
                    slug    : this.user.des_slug,
                    id      : $('#id_usuario_logado').val(),
                },
                function(data){
                    if((data == 1)||(data == true)){
                        alert('Nome de usuário atualizado com sucesso!');
                        location.reload();
                    }else{
                        alert('Nome de usuário já existe!');
                    }
                });
            }
            e.preventDefault();
        },

        salvarNome: function(e){
            if(!this.user.des_nome){
                alert('O campo "Nome Completo" não pode estar vazio!');
            }else{
                let res = (this.user.des_nome.split(" "));
                $('#nomeSimplesLogged').text(res[0]+' '+res[res.length-1]);
                $('#navbar-username').text(res[0]);
                $.post('_utils/ajax_perfil.php',
                {
                    acao    : 'up_generico',
                    campo   : 'des_nome',
                    valor   : this.user.des_nome,
                    id      : $('#id_usuario_logado').val()
                },
                function(data){
                });
                alert('Nome atualizado com sucesso!');
            }
            e.preventDefault();
        },

        salvarEmail: function(e){
            if(!this.user.des_email){
                alert('O campo "Email" não pode estar vazio!');
            }else{
                $('#emailLogged').text(this.user.des_email);
                $.post('_utils/ajax_perfil.php',
                {
                    acao    : 'up_email',
                    email   : this.user.des_email,
                    id      : $('#id_usuario_logado').val(),
                },
                function(data){
                    if(data == 0){
                        alert('Email inválido ou já cadastrado!');
                    }else{
                        alert('Email atualizado com sucesso!');
                    }
                });
            }
            e.preventDefault();
        },

        salvarOcupacao: function(e){
            $.post('_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'des_ocupacao',
                valor   : this.user.des_ocupacao,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Ocupação atualizada com sucesso!');
            e.preventDefault();
        },

    // ---------------------------------------------------------------------------
    //          METODOS DAS INFORMACOES Pessoais
    // ---------------------------------------------------------------------------
        
        salvarCelular: function(e){
            $.post('_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'des_telefone',
                valor   : this.user.des_telefone,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Número de celular atualizado com sucesso!');
            e.preventDefault();
        },

        salvarCpf: function(e){
            $.post('_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'des_cpf',
                valor   : this.user.des_cpf,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Número de CPF atualizado com sucesso!');
            e.preventDefault();
        },

        salvarDtNasc: function(e){
            $.post('_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'dt_nasc',
                valor   : this.user.dt_nasc,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Data de nascimento atualizado com sucesso!');
            e.preventDefault();
        },

        salvarSexo: function(e){
            $.post('_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'des_sexo',
                valor   : this.user.des_sexo.substr(0, 1),
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Sexo atualizado com sucesso!');
            e.preventDefault();
        },

        salvarCidade: function(e){
            $.post('_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'id_cidade',
                valor   : this.user.id_cidade,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
                alert(data);
            });
            alert('Cidade atualizada com sucesso!');
            e.preventDefault();
        },

        deletarConta: function(e){
            let id_usuario = $('#id_usuario_logado').val();
            
            if (confirm('Realmente deseja deletar sua conta?')){
                $.post('_utils/ajax_perfil.php',
                {
                    acao: 'delete_user',
                    id_usuario: id_usuario
                },function(data){
                    // alert(data);
                    window.location.href = 'home';
                });
            }
        },
        
    // ---------------------------------------------------------------------------
    //          METODOS PARA ALTERAR SENHA
    // ---------------------------------------------------------------------------
        
        salvarSenha: function(e){
            if(this.senha !== this.confirmSenha){
                alert('As senhas não são iguais!');
            }else if(this.senha.length < 8){
                alert('A senha deve conter no mínimo 8 digítos!');
            }else{
                $.post('_utils/ajax_perfil.php',
                {
                    acao    : 'up_generico',
                    campo   : 'des_senha',
                    valor   : this.senha,
                    id      : $('#id_usuario_logado').val(),
                },
                function(data){
                });
                this.senha = null;
                this.confirmSenha = null;
                alert('Senha atualizada com sucesso!');
            }
            e.preventDefault();
        },
    }
});
