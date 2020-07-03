function buscaAssistentes() {
    $.ajax({
        type: 'GET',
        url: '/cadastro/profissional/assistente/list',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            populaTabelaAssistentes(data);
        },
        complete: function() {
            console.log('done!');
        }
    });
}

function alteraStatus(idAssistente) {
    $.ajax({
        type: 'POST',
        url: '/cadastro/profissional/assistente/update',
        data: { idAssistente: idAssistente },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            buscaAssistentes();
        },
        complete: function() {
            $('#modal-alerta').modal('hide');
        }
    });
}

function populaTabelaAssistentes(data) {
    var table = $('#tblAssistentes');
    table.empty();

    var content = '';
    if (data.length === 0) {
        content += '<h4>Não há assistentes cadastrados.</h4>';
    } else {
        content += '<table class="table table-striped">';
        content += '<thead>';
        content += '<tr>';
        content += '<th class="custom-table-col-index">#</th><th>Nome</th><th>Usuário</th><th>email</th><th>RG</th><th>CPF</th><th>Status</th><th></th>';
        content += '</tr>';
        content += '</thead>';
        content += '<tbody>';
        $.each(data, function(key, obj) {
            var classBotaoAlteraStatus = 'btn-danger';
            var textoBotaoAlteraStatus = 'Inativar';
            if (obj.status === 'Inativo') {
                classBotaoAlteraStatus = 'btn-success';
                textoBotaoAlteraStatus = 'Ativar';
            }
            var botaoAlteraStatus = '<button class="btn ' + classBotaoAlteraStatus + ' btn-sm btn-alterar-status" style="width: 75px;" data-id_assistente="' + obj.id + '"><span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>&nbsp;' + textoBotaoAlteraStatus + '</button>';
            content += '<tr>';
            content += '<td>' + (1 + key) + '</td>';
            content += '<td>' + obj.nome + '</td>';
            content += '<td>' + obj.username + '</td>';
            content += '<td>' + obj.email + '</td>';
            content += '<td>' + obj.rg + '</td>';
            content += '<td>' + obj.cpf + '</td>';
            content += '<td>' + obj.status + '</td>';
            content += '<td>' + botaoAlteraStatus + '</td>';
            content += '</tr>';
        });
        content += '</tbody>';
        content += '</table>';
    }
    table.append(content);
    table.fadeIn();
}

$(document).ready(function() {
    buscaAssistentes();

    // Listener Botão Alterar Status
    $('#tblAssistentes').on('click', '.btn-alterar-status', function() {
        var btn = $(this);
        var idAssistente = btn.data('id_assistente');
        var row = btn.closest('tr');
        var modal = $('#modal-alerta');

        var message = 'Confirma a alteração de status de ' + row.find('td:eq(1)').text();

        var btnModalSubmit = $('#btn-modal-alerta-submit');

        modal.data('id_assistente', idAssistente);
        modal.data('message', message);
        modal.modal('show');
    });

    // Botão "Submit" da Modal Alerta (Altera Status)
    $('#btn-modal-alerta-submit').on('click', function() {
        var modal = $('#modal-alerta');
        var idAssistente = modal.data('id_assistente');

        alteraStatus(idAssistente);
    });

    // Modal Alerta, ajusta texto para exibir
    $('#modal-alerta').on('show.bs.modal', function() {
        var modal = $(this);
        modal.find('.modal-body p').html(modal.data('message'));
    });


});
