function checkUniqueLogin(username) {
    return new Promise(
        function(resolve, reject) {
            $.ajax({
                type: 'GET',
                url: '/cadastro/username/check',
                data: { username: username },
                success: function(data) {
                    resolve(data);
                },
                error: function(err) {
                    reject(err);
                }
            });
        }
    );
}

$(document).ready(function() {
    $('#txtSenhaConfirma').on('focusout', function() {
        var formGroup = $(this).closest('.form-group');
        formGroup.removeClass('has-error');
        formGroup.find('.help-block').remove();
    });

    $('#txtUsuario').on('focusout', function() {
        var formGroup = $(this).closest('.form-group');
        formGroup.removeClass('has-error');
        formGroup.find('.help-block').remove();
    });

    // Valida senha/confirmacão e username
    $('form').on('submit', function(e) {
        e.preventDefault();
        var form = this;

        var senha = $('#txtSenha');
        var confirmacao = $('#txtSenhaConfirma')
        var usuario = $('#txtUsuario');

        // Checa senha e confirmação de senha
        if (senha.val() !== confirmacao.val()) {
            var validationMessage = '<span class="help-block">Senha e Confirmação de Senha não conferem!</span>';
            var formGroup = confirmacao.closest('.form-group');

            formGroup.addClass('has-error');
            formGroup.append(validationMessage);
            confirmacao.focus();

            return;
        }

        // Checa se já existe usuario (login)
        checkUniqueLogin(usuario.val()).then(
            function(data) {
                if (data.status === 'OK') {
                    form.submit();
                } else {
                    var validationMessage = '<span class="help-block">' + data.message + '</span>';
                    var formGroup = usuario.closest('.form-group');

                    formGroup.addClass('has-error');
                    formGroup.append(validationMessage);
                    usuario.focus();

                    return;
                }
            }
        );

    });

});
