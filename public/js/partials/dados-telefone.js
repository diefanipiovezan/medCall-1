// Botão - (menos), remove telefone (tipo e número) da página
$('#divTelefones').on('click', 'div.btn-remover-telefone', function() {
    $(this).closest('.row').remove();
});

// Botão + (mais), adiciona telefone (tipo e número) na página
$('#btnAdicionarTelefone').on('click', function() {
    var cboTipoTelefone = $("[name^='cboTipoTelefone']:first").clone();
    var txtNumeroTelefone = $("[name^='txtNumeroTelefone']:first").clone();

    var novo = $('<div class="row">\
                        <div class="col-md-4">\
                            <div class="form-group">\
                                <label class="col-md-6 control-label">Tipo de Telefone</label>\
                                <div class="col-md-6 cbo-tipo-telefone">\
                                </div>\
                            </div>\
                        </div>\
                        <div class="col-md-4">\
                            <div class="form-group">\
                                <label class="col-md-2 control-label">Número</label>\
                                <div class="col-md-6 txt-numero-telefone">\
                                </div>\
                                <div class="col-md-1">\
                                    <div class="btn btn-danger btn-remover-telefone">\
                                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                </div>');

    $('#divTelefones').append(novo);
    $('.cbo-tipo-telefone:last').append(cboTipoTelefone);
    $('.txt-numero-telefone:last').append(txtNumeroTelefone.val(''));
});
