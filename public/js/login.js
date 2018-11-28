var app = new Vue({
    el: '#app',
    data: {
        email: '',
        senha: ''
    },
    methods: {
        checkForm: function (e) {
            if (!this.email || !this.senha) {
                swal ( "Oops!" ,  "Preencha todos os campos!" ,  "error" );
            } else {
                $('#loginuser').attr('disabled', 'disabled');
                $.post('_utils/ajax_perfil.php',
                    {
                        acao: 'login',
                        des_email: this.email,
                        des_senha: this.senha,
                    },
                    function (data) {
                        if ((data) || (data == 1)) {
                            window.location.href = $("#returnUrl").val();
                        } else {
                            swal ( "Oops!" ,  "Email e/ou Senha incorreta!" ,  "error" );
                            $('#loginuser').removeAttr('disabled');
                        }
                    });
            }
            e.preventDefault();
        }
    }
})