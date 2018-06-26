var app = new Vue({
    el: '#app',
    data: {
        nome: null,
        email: null,
        senha: null,
        sexo: null,
        dt_nasc: null
    },
    methods: {
        checkForm: function (e) {
            if ((!this.nome)||(!this.email)||(!this.senha)||(!this.sexo)||(!this.dt_nasc)){
                alert('Preencha todos os campos');
            }else{
                $.post('view/_utils/ajax_perfil.php',
                {
                    acao        : 'register',
                    des_nome    : this.nome,
                    des_email   : this.email,
                    des_senha   : this.senha,
                    des_sexo    : this.sexo,
                    dt_nasc     : this.dt_nasc
                },
                function(data){
                    if((data) || (data == 1)){
                        window.location.reload();
                    }else{
                        $('#register-alert').removeClass('d-none');
                    }
                });
            }
            e.preventDefault();
        }
    }
})