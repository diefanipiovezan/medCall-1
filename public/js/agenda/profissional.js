const nomeDias = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

const statusIcon = [
    '<span class="glyphicon glyphicon-time" aria-hidden="true" style="color:orange;"></span>',
    '<span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span>',
    '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:blue;"></span>',
    '<span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span>'
];

const descricaoPagamentos = [
    'Dinheiro',
    'Crédito',
    'Débito'
];

function populaTabelaAgenda(data) {
    var table = $('#tblAngedaProfissional');
    table.empty();
    var content = '';

    if (data.length === 0) {
        content += '<h2 class="custom-table-title-h2">Não há itens cadastrados na sua Agenda!</h2>';
    } else {
        content += '<h2 class="custom-table-title-h2">Agenda</h2>';
        content += '<table class="table table-striped>"';
        content += '<thead>';
        content += '<tr>';
        content += '<th class="custom-table-col-index">#</th><th class="custom-table-col-index">Status</th><th>Data</th><th>Dia</th><th>Horário</th><th>Paciente</th><th></th>';
        content += '</tr>';
        content += '</thead>';
        content += '<tbody>';
        $.each(data, function(key, obj) {
            var iconDeficienciaAuditiva = '';
            if (obj.deficiencia_auditiva === 'S') {
                iconDeficienciaAuditiva = '&nbsp;&nbsp;<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color:red;"></span>';
            }
            content += '<tr>';
            content += '<td>' + (1 + key) + '</td>';
            content += '<td>' + statusIcon[obj.status] + iconDeficienciaAuditiva + '</td>';
            content += '<td>' + obj.dia + '</td>';
            content += '<td>' + nomeDias[(obj.dia_semana - 1)] + '</td>';
            content += '<td>' + obj.horario + '</td>';
            content += '<td>' + obj.paciente + '</td>';
            var btnAgendamentoInfos = '<button class="btn btn-xs btn-primary btn-agendamento-info" data-id_agendamento="' + obj.id + '"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></button>';
            var btnAgendamentoAprovar = '<button class="btn btn-xs btn-success btn-agendamento-agendar" data-id_agendamento="' + obj.id + '"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>';
            var btnAgendamentoReprovar = '<button class="btn btn-xs btn-danger btn-agendamento-cancelar" data-id_agendamento="' + obj.id + '"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>';
            if (parseInt(obj.status, 10) === 0) {
                content += '<td>' + btnAgendamentoInfos + '&nbsp;' + btnAgendamentoAprovar + '&nbsp;' + btnAgendamentoReprovar + '</td>';
            } else if (parseInt(obj.status, 10) === 1) {
                content += '<td>' + btnAgendamentoInfos + '&nbsp;' + btnAgendamentoReprovar + '</td>';
            } else {
                content += '<td>' + btnAgendamentoInfos + '&nbsp;' + '</td>';
            }
            content += '</tr>';
        });
        content += '</tbody>';
        content += '</table>';
    }

    table.append(content);
    table.fadeIn();
}

function populaModalDetalhes(data) {
    var modal = $('#modal-detalhes');
    var modalBody = modal.find('.modal-body');
    modalBody.empty();

    var content = '';
    if (data['dados'][0].deficiencia_auditiva === 'S') {
        content += '<div class="alert alert-danger" role="alert">';
        content += '<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true" style="color:red;"></span>&nbsp;Este Paciente possui deficiência auditiva, contate-o via email ou mensagem';
        content += '</div>'
    }
    content += '<div class="row">';
    content += '<div class="col-md-12">';
    content += '<h4>' + data['dados'][0].procedimento + '</h4>';
    content += '</div>';
    content += '</div>';

    content += '<div class="row">';
    if (data['dados'][0].convenio) {
        content += '<div class="col-md-12">';
        content += 'Convênio ' + data['dados'][0].convenio;
        content += '</div>';
    } else {
        content += '<div class="col-md-6">';
        content += 'Pagamento: ' + descricaoPagamentos[(data['dados'][0].pagamento - 1)];
        content += '</div>';
        content += '<div class="col-md-6">';
        content += 'Valor: R$ ' + data['dados'][0].valor;
        content += '</div>';
    }
    content += '</div>';

    content += '<br />';

    content += '<div class="row">';
    content += '<div class="col-md-12">';
    content += '<h4>' + data['dados'][0].nome + '</h4>';
    content += '</div>';
    content += '</div>';

    content += '<div class="row">';
    content += '<div class="col-md-4">';
    content += 'Nascimento: ' + data['dados'][0].dt_nascimento;
    content += '</div>';
    content += '<div class="col-md-8">';
    content += 'RG: ' + data['dados'][0].rg;
    content += '</div>';
    content += '</div>';

    content += '<div class="row">';
    content += '<div class="col-md-4">';
    content += 'CPF: ' + data['dados'][0].cpf
    content += '</div>';
    content += '<div class="col-md-8">';
    content += 'email: ' + data['dados'][0].email
    content += '</div>';
    content += '</div>';

    content += '<div class="row">';
    content += '<div class="col-md-9">';
    content += data['dados'][0].logradouro + ', ' + data['dados'][0].numero + ' ' + data['dados'][0].complemento;
    content += '</div>';
    content += '</div>';

    content += '<div class="row">';
    content += '<div class="col-md-12">';
    content += data['dados'][0].bairro + ', ' + data['dados'][0].cidade + ' - ' + data['dados'][0].uf + ' - ' + data['dados'][0].cep;
    content += '</div>';
    content += '</div>';

    content += '<div class="row">';
    content += '<div class="col-md-12">';
    $.each(data['fones'], function(key, obj) {
        content += obj.tipo + ' (' + obj.ddd + ') ' + obj.numero + ' ';
    });
    content += '</div>';
    content += '</div>';

    // content += '<div class="row">';
    // content += '<div class="col-md-12">';
    // content += '</div>';
    // content += '</div>';

    modalBody.append(content);
    modal.modal('show');
}

function buscaAgendaProfissional() {
    $.ajax({
        type: 'GET',
        url: '/agenda/profissional/list',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            //console.log(data);
            populaTabelaAgenda(data);
        },
        error: function(err) {
            console.log(err);
        },
        complete: function() {

        }
    });
}

function buscaDetalhesAgendamento(idAgendamento) {
    $.ajax({
        type: 'GET',
        url: '/agenda/profissional/details',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { idAgendamento: idAgendamento },
        success: function(data) {
            populaModalDetalhes(data);
        },
        error: function(err) {
            console.log(err);
        },
        complete: function() {

        }
    });
}

function alterarAgendamentoProfissional(idAgendamento, url) {
    $.ajax({
        type: 'POST',
        url: url,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { idAgendamento: idAgendamento },
        success: function(data) {
            buscaAgendaProfissional();
        },
        error: function(err) {
            console.log(err);
        },
        complete: function() {
            $('#modal-alerta').modal('hide');
        }
    });
}

$(document).ready(function() {
    buscaAgendaProfissional();

    // Listener Botão Infos
    $('#tblAngedaProfissional').on('click', '.btn-agendamento-info', function() {
        var btn = $(this);
        var idAgendamento = btn.data('id_agendamento');
        buscaDetalhesAgendamento(idAgendamento);
    });

    // Listener Botão Aprovar
    $('#tblAngedaProfissional').on('click', '.btn-agendamento-agendar', function() {
        var btn = $(this);
        var idAgendamento = btn.data('id_agendamento');
        var row = btn.closest('tr');
        var modal = $('#modal-alerta');

        var message = 'Confirma o <b>agendamento</b> de ' + row.find('td:eq(5)').text();
        message += ' em ' + row.find('td:eq(2)').text();
        message += ', ' + row.find('td:eq(3)').text();
        message += ' as ' + row.find('td:eq(4)').text() + 'h?';

        var btnModalSubmit = $('#btn-modal-alerta-submit');
        btnModalSubmit.removeClass('btn-default, btn-danger');
        btnModalSubmit.addClass('btn-success');
        btnModalSubmit.text('Confirmar');

        modal.data('id_agendamento', idAgendamento);
        modal.data('url', '/agenda/profissional/approve');
        modal.data('message', message);
        modal.modal('show');
    });

    // Listener Botão Reprovar
    $('#tblAngedaProfissional').on('click', '.btn-agendamento-cancelar', function() {
        var btn = $(this);
        var idAgendamento = btn.data('id_agendamento');
        var row = btn.closest('tr');
        var modal = $('#modal-alerta');

        var message = 'Confirma o <b>cancelamento</b> de ' + row.find('td:eq(5)').text();
        message += ' em ' + row.find('td:eq(2)').text();
        message += ', ' + row.find('td:eq(3)').text();
        message += ' as ' + row.find('td:eq(4)').text() + 'h?';

        var btnModalSubmit = $('#btn-modal-alerta-submit');
        btnModalSubmit.removeClass('btn-default, btn-success');
        btnModalSubmit.addClass('btn-danger');
        btnModalSubmit.text('Cancelar');

        modal.data('id_agendamento', idAgendamento);
        modal.data('url', '/agenda/profissional/cancel');
        modal.data('message', message);
        modal.modal('show');
    });

    // Botão "Submit" da Modal Alerta (Aprova ou Desaprova)
    $('#btn-modal-alerta-submit').on('click', function() {
        var modal = $('#modal-alerta');
        var idAgendamento = modal.data('id_agendamento');
        var url = modal.data('url');

        alterarAgendamentoProfissional(idAgendamento, url);
    });

    // Modal Alerta, ajusta texto para exibir
    $('#modal-alerta').on('show.bs.modal', function() {
        var modal = $(this);
        modal.find('.modal-body p').html(modal.data('message'));
    });
});
