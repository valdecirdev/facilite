var app = new Vue({
    el: '#app',
    data: {
        nome: '',
        email: '',
        senha: '',
        sexo: '',
        dt_nasc: ''
    },
    methods: {
        checkForm: function (e) {
            let valida_nome = this.nome.split(' ');

            if ((!this.nome)||(!this.email)||(!this.senha)||(!this.sexo)||(!this.dt_nasc)) {
                swal ( "Oops!" ,  "Preencha todos os campos!" ,  "error" );
            } else if(this.senha.length < 8) {
                swal ( "Oops!" ,  "A senha deve conter no mínimo 8 digítos!" ,  "error" );
            } else if(valida_nome.length < 2) {
                swal ( "Oops!" ,  "Digite o nome completo" ,  "error" );
            } else {
                $('#registeruser').attr('disabled', 'disabled');
                $.post('_utils/ajax_perfil.php',
                {
                    acao        : 'register',
                    des_nome    : this.nome,
                    des_email   : this.email,
                    des_senha   : this.senha,
                    des_sexo    : this.sexo,
                    dt_nasc     : this.dt_nasc
                },
                function(data){
                    if((data) || (data === 1)){
                        window.location.href = $("#returnUrl").val();
                    }else{
                        swal ( "Oops!" ,  "Email inválido ou já cadastrado!" ,  "error" );
                        $('#registeruser').removeAttr('disabled');
                    }
                });
            }
            e.preventDefault();
        }
    }
})
