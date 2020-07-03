const nomeDias = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];

function populaTabelaHorarioByDay(dia, horarios) {
    var table = $('#tblDia0' + dia);
    table.empty();

    if (horarios.length) {
        var content = '<table class="table table-striped table-condensed">';
        content += '<tbody>';
        $.each(horarios, function(key, obj) {
            var btnRemove = '<button class="btn btn-danger btn-xs pull-right" data-id="' + obj.id + '" data-dia="' + dia + '" data-horario="' + obj.horario + '" data-toggle="modal" data-target="#modal-excluir-horario">';
            btnRemove += '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
            btnRemove += '</button>';

            content += '<tr>';
            content += '<td>';
            content += obj.horario.substring(0,5) + '&nbsp;h';
            content += '</td>';
            content += '<td>';
            content += btnRemove;
            content += '</td>';
            content += '</tr>';
        });
        content += '</tbody>';
        content += '</table>';
    } else {
        var content = '<div class="col-md-12">';
        content += 'Não há horários cadastrados!';
        content += '</div>';
    }

    table.append(content);
}

function populaTabelasHorario(data) {
    var disponibilidade = JSON.parse(data);

    for (var i = 1; i < 8; i++) {
        populaTabelaHorarioByDay(i, disponibilidade['dia0' + i]);
    }
}

function getHorariosDisponiveis() {
    $.ajax({
        type: 'GET',
        url: '/cadastro/profissional/disponibilidade/horarios',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            populaTabelasHorario(data);
        },
        complete: function() {
            console.log('done!');
        }
    });
}

function addDisponibilidadeProfissional() {
    var dia = $('#btnSalvarHorario').data('dia');
    var horario = $('#txtHorarioDisponivel').val();

    $.ajax({
        type: 'POST',
        url: '/cadastro/profissional/disponibilidade/add',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { dia: dia, horario: horario },
        success: function(data) {
            getHorariosDisponiveis();
        },
        complete: function() {
            $('#modal-adicionar-horario').modal('hide');
        }
    });
}


function dropDisponibilidadeProfissional() {
    var idDisponibilidade = $('#btnExcluirHorario').data('id_disponibilidade');

    $.ajax({
        type: 'POST',
        url: '/cadastro/profissional/disponibilidade/drop',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { idDisponibilidade: idDisponibilidade},
        success: function(data) {
            getHorariosDisponiveis();
        },
        complete: function() {
            $('#modal-excluir-horario').modal('hide');
        }
    });
}

$(document).ready(function() {
    getHorariosDisponiveis();

    // Listener Botão Salvar Horário
    $('#btnSalvarHorario').on('click', function() {
        addDisponibilidadeProfissional();
    });

    // Listener Botão Excluir Horário
    $('#btnExcluirHorario').on('click', function() {
        dropDisponibilidadeProfissional();
    });

    // Modal Adicionar Horário (Ajusta informações para exibir)
    $('#modal-adicionar-horario').on('show.bs.modal', function(e) {
        var btn = $(e.relatedTarget);
        var dia = btn.data('dia');

        var modal = $(this);
        modal.find('#btnSalvarHorario').data('dia', dia);
        modal.find('.modal-body label').html('Horário para ' + nomeDias[dia -1]);
    });

    // Modal Confirma Exclusão de Horário (Ajusta informações para exibir)
    $('#modal-excluir-horario').on('show.bs.modal', function(e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        var dia = btn.data('dia');
        var horario = btn.data('horario');

        // Seta elementos da Modal (texto e id do convênio como data attribute do botão Excluir)
        var modal = $(this);
        modal.find('#btnExcluirHorario').data('id_disponibilidade', id);
        modal.find('.modal-body p').html('Confirma exclusão da disponibilidade <b>' + nomeDias[dia -1] + ' - ' + horario.substring(0,5) + '&nbsp;h' + '</b>');
    });
});
