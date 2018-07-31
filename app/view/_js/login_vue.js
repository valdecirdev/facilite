var app = new Vue({
    el: '#app',
    data: {
        email: null,
        senha: null
    },
    methods: {
        checkForm: function (e) {
            $.post('app/view/_utils/ajax_perfil.php',
            {
                acao            : 'login',
                login_des_email : this.email,
                des_senha       : this.senha
            },
            function(data){
                if((data) || (data == 1)){
                    window.location.reload();
                }else{
                    $('#login-alert').removeClass('d-none');
                }
            });
            e.preventDefault();
        }
    }
})