const nomeDias = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

function populaCidades(cidades) {
    var cboCidade = $('#cboCidade');

    cboCidade.empty();
    $('#cboEspecialidade').empty();
    $('#cboProcedimento').empty();

    $('<option />', { value: '', text: '' }).appendTo(cboCidade);
    $.each(cidades, function(key, obj) {
        $('<option />', { value: obj.id, text: obj.nome }).appendTo(cboCidade);
    });
}

function populaEspecialidades(especialidades) {
    var cboEspecialidade = $('#cboEspecialidade');

    cboEspecialidade.empty();
    $('<option />', { value: '', text: '' }).appendTo(cboEspecialidade);
    $.each(especialidades, function(key, obj) {
        $('<option />', { value: obj.id, text: obj.especialidade }).appendTo(cboEspecialidade);
    });
}

function populaProcedimentos(procedimentos) {
    var cboProcedimento = $('#cboProcedimento');

    cboProcedimento.empty();
    $('<option />', { value: '', text: '' }).appendTo(cboProcedimento);
    $.each(procedimentos, function(key, obj) {
        $('<option />', { value: obj.id, text: obj.procedimento }).appendTo(cboProcedimento);
    });
}

function populaConvenios(convenios) {
    var cboConvenio = $('#cboConvenio');

    cboConvenio.empty();
    $('<option />', { value: '', text: '' }).appendTo(cboConvenio);
    $.each(convenios, function(key, obj) {
        $('<option />', { value: obj.id, text: obj.convenio  }).appendTo(cboConvenio);
    });
}

function populaTabelaProfissionaisDisponiveis(data) {
    var profissionais = JSON.parse(data);
    var table = $('#tblProfissionaisDisponiveis');
    table.empty();

    if (profissionais.length > 0) {
        var content = '<table class="table table-striped">';
        content += '<thead>';
        content += '<tr>';
        content += '<th class="custom-table-col-index">#</th><th>Profissional / Instituição</th><th></th>';
        content += '</tr>';
        content += '</thead>';
        content += '<tbody>';
        $.each(profissionais, function(key, obj) {
            content += '<tr>';
            content += '<td>' + (key + 1) + '</td><td>' + obj.profissional + '</td><td><button class="btn btn-sm btn-primary pull-right btn-detalhes" data-id_profissional="' + obj.id_profissional + '"><span class="glyphicon glyphicon-list" aria-hidden="true"></span>&nbsp;Detalhes</button></td>';
            content += '</tr>';
        });
        content += '</tbody>';
        content += '</table>'
    } else {
        var content = '<h3>Sua busca não retornou resultados!</h3>';
    }

    table.append(content);
    $('#bgMedcall').fadeOut(function() {
        table.fadeIn();
    });
}

function populaTableDetalhesProfissional(data) {
    var table = $('#tblDetalhesProfissional');
    table.empty();

    var content = '<div class="jumbotron custom-jumbotron-padding">';
    content += '<h2>' + data.dados[0].nome + '</h2>';
    content += '<h3>Registro: ' + data.dados[0].registro + '</h3>';
    content += '<p>' + data.dados[0].logradouro + ', ' + data.dados[0].numero + '</p>';
    if (data.dados[0].complemento !== '') {
        content += '<p>' + data.dados[0].complemento + '</p>';
    }
    content += '<p>' + data.dados[0].bairro + '</p>';
    content += '<p>' + data.dados[0].cep + '</p>';
    if (data.fones) {
        content += '<p>';
        $.each(data.fones, function(key, obj) {
            content += obj.tipo_telefone.tipo + ': (' + obj.ddd + ') ' + obj.numero + ' ';
        });
        content += '</p>';
    }
    content += '<div class="row">';
    content += '<div class="col-md-6">';
    content += '<table class="table table-condensed">';
    content += '<thead>';
    content += '<tr>';
    content += '<th class="custom-table-col-index">#</th><th>Especialidades</th>';
    content += '</tr>';
    content += '</thead>';
    content += '<tbody>';
    $.each(data.especialidades, function(key, obj) {
        content += '<tr>';
        content += '<td>' + (key + 1) + '</td><td>' + obj.especialidade  + '</td>';
        content += '</tr>';
    });
    content += '</tbody>';
    content += '</table>'
    content += '</div>';
    content += '<div class="col-md-6">';
    content += '<table class="table table-condensed">';
    content += '<thead>';
    content += '<tr>';
    content += '<th class="custom-table-col-index">#</th><th>Procedimentos</th>';
    content += '</tr>';
    content += '</thead>';
    content += '<tbody>';
    $.each(data.procedimentos, function(key, obj) {
        content += '<tr>';
        content += '<td>' + (key + 1) + '</td><td>' + obj.procedimento + '</td>';
        content += '</tr>';
    });
    content += '</tbody>';
    content += '</table>'
    content += '</div>';
    content += '</div>'; // row
    content += '<button class="btn btn-warning custom-jumbotron-button-width btn-detalhes-voltar"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>&nbsp;Voltar</button>&nbsp;&nbsp;';
    content += '<button class="btn btn-primary custom-jumbotron-button-width btn-detalhes-horarios" data-id_profissional="' + data.dados[0].id + '""><span class="glyphicon glyphicon-time aria-hidden="true"></span>&nbsp;Horários</button>';
    content += '</div>';

    table.append(content);
    $('#tblProfissionaisDisponiveis').fadeOut(function() {
        table.fadeIn();
    });
}

function populaTableHorariosDisponiveisProfissional(data) {
    var horarios = JSON.parse(data);
    var table = $('#tblHorariosProfissional');
    table.empty();

    var content = '<h2 class="custom-table-title-h2">' + $('#tblDetalhesProfissional').find('.jumbotron h2').text() + '<button class="btn btn-warning btn-horarios-voltar pull-right"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>&nbsp;Voltar</button></h2>';
    content += '<table class="table table-striped>"';
    content += '<thead>';
    content += '<tr>';
    content += '<th class="custom-table-col-index">#</th><th>Data</th><th>Dia</th><th>Horário</th><th></th>';
    content += '</tr>';
    content += '</thead>';
    content += '<tbody>';
    $.each(horarios, function(key, obj) {
        content += '<tr>';
        content += '<td>' + (key + 1) + '</td><td>' + obj.dia;
        content += '</td><td>' + nomeDias[obj.dia_semana -1];
        content += '</td><td>' + obj.horario;
        content += '</td><td><button class="btn btn-sm btn-primary btn-agendar" data-id_profissional="' + obj.id_profissional + '" data-horario="' + obj.horario + '" data-dia="' + obj.dia + '"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>&nbsp;Agendar</button>'
        content += '</tr>';
    });
    content += '</tbody>';
    content += '</table>';

    table.append(content);
    $('#tblDetalhesProfissional').fadeOut(function() {
        table.fadeIn()
    });
}

function buscaCidades(idEstado) {
    if (idEstado !== '') {
        $.ajax({
            type: 'GET',
            url: '/cadastro/busca/cidades',
            data: { idEstado: idEstado },
            success: function(data) {
                populaCidades(data);
            },
            error: function(err) {
                // TODO: Tratar erro
                console.log(err);
            }
        });
    } else {
        populaCidades([]);
    }
}

function buscaEspecialidades(idCidade) {
    if (idCidade !== '') {
        $.ajax({
            type: 'GET',
            url: '/agenda/profissional/especialidades',
            data: { idCidade: idCidade },
            success: function(data) {
                populaEspecialidades(data);
            },
            error: function(err) {
                // TODO: Tratar erro
                console.log(err);
            }
        });
    } else {
        populaEspecialidades([]);
    }
}

function buscaProcedimentos(idCidade) {
    if (idCidade !== '') {
        $.ajax({
            type: 'GET',
            url: '/agenda/profissional/procedimentos',
            data: { idCidade: idCidade },
            success: function(data) {
                populaProcedimentos(data);
            },
            error: function(err) {
                // TODO: Tratar erro
                console.log(err);
            }
        });
    } else {
        populaProcedimentos([]);
    }
}

function buscaConvenios(idCidade) {
    if (idCidade !== '') {
        $.ajax({
            type: 'GET',
            url: '/agenda/profissional/convenios',
            data: { idCidade: idCidade },
            success: function(data) {
                populaConvenios(data);
            },
            error: function(err) {
                // TODO: Tratar erro
                console.log(err);
            }
        });
    } else {
        populaConvenios([]);
    }
}

function buscaProfissionaisDisponiveis() {
    var cidade = $('#cboCidade').val();
    var especialidade = $('#cboEspecialidade').val();
    var procedimento = $('#cboProcedimento').val();
    var convenio = $('#cboConvenio').val();

    $.ajax({
        type: 'GET',
        url: '/agenda/profissional/disponiveis',
        data: { cidade: cidade, especialidade: especialidade, procedimento: procedimento, convenio: convenio },
        success: function(data) {
            populaTabelaProfissionaisDisponiveis(data);
            // console.log(data);
        },
        error: function(err) {
            console.log(err);
        }
    });
}

function buscaDetalhesProfissional(idProfissional) {
    $.ajax({
        type: 'GET',
        url: '/agenda/profissional/detalhes',
        data: { idProfissional: idProfissional },
        success: function(data) {
            // console.log(data);
            populaTableDetalhesProfissional(data);
        },
        error: function(err) {
            console.log(err);
        }
    });
}

function buscaHorariosDisponiveisProfissional(idProfissional) {
    $.ajax({
        type: 'GET',
        cache: false,
        url: '/agenda/profissional/disponivel/horarios',
        data: { idProfissional: idProfissional },
        success: function(data) {
            // console.log(data);
            populaTableHorariosDisponiveisProfissional(data);
        },
        error: function(err) {
            console.log(err);
        }
    });
}

function solicitaAgendamento(dia, horario, id_profissional) {
    $.ajax({
        type: 'GET',
        url: '/agenda/profissional/agendamento',
        data: {
            dia: dia,
            horario: horario,
            id_profissional: id_profissional
        },
        success: function(data) {
            var modal = $('#modal-agendamento');
            modal.find('.modal-content').html(data);
            modal.modal('show');
        },
        error: function(err) {
            console.log(err);
        }
    });
}

function salvarAgendamentoProfissional(frmData) {
    $.ajax({
        type: 'POST',
        url: '/agenda/profissional/agendamento/add',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: frmData,
        success: function(data) {
            var modal = $('#modal-alerta');
            var hidIdProfissional = $('[name="txtIdProfissional"]');

            modal.data('message', data.message);
            buscaHorariosDisponiveisProfissional(hidIdProfissional.val());
        },
        error: function(err) {
            console.log(err);
        },
        complete: function() {
            $('#modal-agendamento').modal('hide');
            $('#modal-alerta').modal('show');
        }
    });
}

function limpaResultadoPesquisa() {
    var bgMedcall = $('#bgMedcall');
    var tblProfissionaisDisponiveis = $('#tblProfissionaisDisponiveis');
    var tblDetalhesProfissional = $('#tblDetalhesProfissional');
    var tblHorariosProfissional = $('#tblHorariosProfissional');

    if (tblHorariosProfissional.is(':visible')) {
        tblHorariosProfissional.fadeOut();
        return;
    }

    if (tblDetalhesProfissional.is(':visible')) {
        tblDetalhesProfissional.fadeOut();
        return;
    }

    if (tblProfissionaisDisponiveis.is(':visible')) {
        tblProfissionaisDisponiveis.fadeOut(function() {
            bgMedcall.fadeIn();
        });
        return;
    }
}

$(document).ready(function() {
    // Change combo Estado
    $('#cboEstado').on('change', function() {
        buscaCidades($(this).val());
    });

    // Change combo Cidade
    $('#cboCidade').on('change', function() {
        var idCidade = $(this).val();
        buscaEspecialidades(idCidade);
        buscaProcedimentos(idCidade);
        buscaConvenios(idCidade);
    });

    // Change dos combos (Geral) - Limpa resultado da Pesquisa
    $('select').on('change', function() {
        limpaResultadoPesquisa();
    });

    // Listerner do Botão Pesquisar
    $('#btnPesquisar').on('click', function(e) {
        e.preventDefault();

        limpaResultadoPesquisa();

        var modal = $('#modal-alerta');
        var cboEstado = $('#cboEstado');
        var cboCidade = $('#cboCidade');

        if (cboEstado.val() === '') {
            modal.data('message', 'Por favor selecione um Estado!');
            modal.modal('show');
            return;
        }

        if (cboCidade.val() === '') {
            modal.data('message', 'Por favor selecione uma Cidade');
            modal.modal('show');
            return;
        }

        buscaProfissionaisDisponiveis();
    });

    // Listerner Botões Detalhes
    $('#tblProfissionaisDisponiveis').on('click', 'button.btn-detalhes', function(e) {
        var button = $(this);
        var idProfissional = button.data('id_profissional');

        buscaDetalhesProfissional(idProfissional);
    });

    // Listener Botão Voltar Detalhes
    $('#tblDetalhesProfissional').on('click', 'button.btn-detalhes-voltar', function() {
        $('#tblDetalhesProfissional').fadeOut(function() {
            $('#tblProfissionaisDisponiveis').fadeIn();
        });
    });

    // Listener Botão Horarios Detalhes
    $('#tblDetalhesProfissional').on('click', 'button.btn-detalhes-horarios', function() {
        var idProfissional = $(this).data('id_profissional');

        buscaHorariosDisponiveisProfissional(idProfissional);
    });

    // Listerner Botão Horarios Voltar
    $('#tblHorariosProfissional').on('click', 'button.btn-horarios-voltar', function() {
        $('#tblHorariosProfissional').fadeOut(function() {
            $('#tblDetalhesProfissional').fadeIn();
        });
    });

    // Listerner Botão Agendar
    $('#tblHorariosProfissional').on('click', 'button.btn-agendar', function() {
        var btn = $(this);
        var dia = btn.data('dia');
        var horario = btn.data('horario');
        var id_profissional = btn.data('id_profissional');
        var modal = $('#modal-agendamento');

        solicitaAgendamento(dia, horario, id_profissional);
    });

    // Modal Alerta, ajusta texto para exibir
    $('#modal-alerta').on('show.bs.modal', function() {
        var modal = $(this);
        modal.find('.modal-body p').html(modal.data('message'));
    });

    // Change Combo Procedimento
    $('#modal-agendamento').on('change', '[name="cboProcedimentoAgendar"]', function() {
        var valor = $(this).find('option:selected').data('valor');
        $('[name="txtValor"]').val(valor);
    });

    // Change Combo Forma Contratação
    $('#modal-agendamento').on('change', '[name="cboContratacaoAgendar"]', function() {
        var cbo = $(this);
        var valor = cbo.val();
        var convenio = $('.group-convenio');
        var pagamento = $('.group-forma-pagamento');
        console.log('valor: ' + valor);

        if (valor == 2) {
            pagamento.find('.form-control').attr('required', 'required');
            convenio.find('.form-control').removeAttr('required');
            convenio.fadeOut(function() {
                pagamento.fadeIn();
            });
        } else if (valor == 1){
            convenio.find('.form-control').attr('required', 'required');
            pagamento.find('.form-control').removeAttr('required');
            pagamento.fadeOut(function() {
                convenio.fadeIn();
            });
        } else {
            pagamento.fadeOut();
            convenio.fadeOut();
        }
    });

    // Botão Salvar agendamento
    $('#modal-agendamento').on('submit', '[name="frmAgendar"]', function(e) {
        e.preventDefault();
        var frmData = $(this).serialize();

        salvarAgendamentoProfissional(frmData);
    });

});
