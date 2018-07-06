var app = new Vue({
    el: '#content',
    data: {
        senha: null,
        confirmSenha: null,
        user: usuario,
    },
    methods: {
    // ---------------------------------------------------------------------------
    //          METODOS DAS INFORMACOES BASICAS
    // ---------------------------------------------------------------------------
        
        salvarUsuario: function(e){
            if(!this.user.nome_usuario){
                alert('O campo "Nome de usuário" não pode estar vazio!');
            }else{
                $.post('view/_utils/ajax_perfil.php',
                {
                    acao    : 'up_slug',
                    slug    : this.user.slug_usuario,
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
            if(!this.user.nome_usuario){
                alert('O campo "Nome Completo" não pode estar vazio!');
            }else{
                var res = (this.user.nome_usuario.split(" "));
                $('#nomeSimplesLogged').text(res[0]+' '+res[res.length-1]);
                $('#navbar-username').text(res[0]);
                $.post('view/_utils/ajax_perfil.php',
                {
                    acao    : 'up_generico',
                    campo   : 'des_nome',
                    valor   : this.user.nome_usuario,
                    id      : $('#id_usuario_logado').val()
                },
                function(data){
                });
                alert('Nome atualizado com sucesso!');
            }
            e.preventDefault();
        },

        salvarEmail: function(e){
            if(!this.user.email_usuario){
                alert('O campo "Email" não pode estar vazio!');
            }else{
                $('#emailLogged').text(this.user.email_usuario);
                $.post('view/_utils/ajax_perfil.php',
                {
                    acao    : 'up_email',
                    email   : this.user.email_usuario,
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
            $.post('view/_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'des_ocupacao',
                valor   : this.user.ocupacao_usuario,
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
            $.post('view/_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'des_telefone',
                valor   : this.user.telefone_usuario,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Número de celular atualizado com sucesso!');
            e.preventDefault();
        },

        salvarCpf: function(e){
            $.post('view/_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'des_cpf',
                valor   : this.user.cpf_usuario,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Número de CPF atualizado com sucesso!');
            e.preventDefault();
        },

        salvarDtNasc: function(e){
            $.post('view/_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'dt_nasc',
                valor   : this.user.dtnasc_usuario,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Data de nascimento atualizado com sucesso!');
            e.preventDefault();
        },

        salvarSexo: function(e){
            $.post('view/_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'des_sexo',
                valor   : this.user.sexo_usuario,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Sexo atualizado com sucesso!');
            e.preventDefault();
        },

        salvarCidade: function(e){
            $.post('view/_utils/ajax_perfil.php',
            {
                acao    : 'up_generico',
                campo   : 'id_cidade',
                valor   : this.user.cidade_usuario,
                id      : $('#id_usuario_logado').val(),
            },
            function(data){
            });
            alert('Cidade atualizada com sucesso!');
            e.preventDefault();
        },
        
    // ---------------------------------------------------------------------------
    //          METODOS PARA ALTERAR SENHA
    // ---------------------------------------------------------------------------
        
        salvarSenha: function(e){
            if(this.senha != this.confirmSenha){
                alert('As senhas não são iguais!');
            }else{
                $.post('view/_utils/ajax_perfil.php',
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