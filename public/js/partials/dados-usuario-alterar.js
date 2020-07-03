$(document).ready(function() {
    $('#btnRedefinirSenha').on('click', function(e) {
        e.preventDefault();

        var btnRedefinirSenha = $(this);
        var divInputsSenha = $('#div-inputs-senha');
        var txtSenha = $('#txtSenha');
        var txtConfirma = $('#txtSenhaConfirma');

        txtSenha.attr('required', 'required');
        txtConfirma.attr('required', 'required');

        btnRedefinirSenha.fadeOut(function() {
            divInputsSenha.fadeIn();
        });

    });

    $('#btnRedefinirSenhaCancelar').on('click', function(e) {
        e.preventDefault();

        var btnRedefinirSenha = $('#btnRedefinirSenha');
        var divInputsSenha = $('#div-inputs-senha');
        var txtSenha = $('#txtSenha');
        var txtConfirma = $('#txtSenhaConfirma');

        txtSenha.removeAttr('required').val('');
        txtConfirma.removeAttr('required').val('');

        divInputsSenha.fadeOut(function() {
            btnRedefinirSenha.fadeIn();
        });
    });

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

        form.submit();

    });

});
