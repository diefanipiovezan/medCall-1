function getConvenios() {
    $.ajax({
        type: 'GET',
        url: '/cadastro/busca/convenios',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            populaComboConvenios(data);
        },
        complete: function() {
            console.log('done!');
        }
    });
}

function getConveniosProfissional() {
    $.ajax({
        type: 'GET',
        url: '/cadastro/profissional/convenios',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            populaConvenios(data);
        },
        complete: function() {
            console.log('done!');
        }
    });
}

function addNewConvenioProfissional() {
    var nome = $('#txtConvenioNovo').val();

    if (nome !== '') {
        $.ajax({
            type: 'POST',
            url: 'profissional/convenio/new',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { nome: nome },
            success: function(data) {
                getConveniosProfissional();
            },
            complete: function() {
                $('#modal-adicionar-convenio').modal('hide');
                $('#pnlConvenioAdd').fadeOut().addClass('hidden');
            }
        });
    }
}

function addConvenioProfissional() {
    var idConvenio = $('#cboConvenio').val();

    if (idConvenio !== '') {
        $.ajax({
            type: 'POST',
            url: '/cadastro/profissional/convenio/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { idConvenio: idConvenio },
            success: function(data) {
                getConveniosProfissional();
            },
            complete: function() {
                $('#pnlConvenioAdd').fadeOut().addClass('hidden');
            }
        });
    }
}

function dropConvenioProfissional() {
    var idConvenio = $('#btnExcluirConvenio').data('id_convenio');

    $.ajax({
        type: 'POST',
        url: '/cadastro/profissional/convenio/drop',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { idConvenio: idConvenio },
        success: function(data) {
            getConveniosProfissional();
        },
        complete: function() {
            $('#modal-excluir-convenio').modal('hide');
        }
    });
}

function populaComboConvenios(convenios) {
    var cboConvenio = $('#cboConvenio');
    cboConvenio.empty();

    $('<option />', { value: '', text: '' }).appendTo(cboConvenio);
    $.each(convenios, function(key, obj) {
        $('<option />', { value: obj.id, text: obj.convenio }).appendTo(cboConvenio);
    });
}

function populaConvenios(data) {
    var convenios = JSON.parse(data);
    var tblConvenios = $('#tblConvenios');
    tblConvenios.empty();

    if (convenios.length) {
        var tblContent = '<table class="table table-condensed table-striped">';
        tblContent += '<thead><tr><th>#</th><th>Convênio</th><th></th></tr></thead>';
        tblContent += '<tbody>';
        $.each(convenios, function(key, obj) {
            var btnRemover = '<button type="button" class="btn btn-xs btn-danger btn-convenio-excluir" aria-label="Left Align" data-id="' + obj.id + '" data-convenio="' + obj.convenio + '" data-toggle="modal" data-target="#modal-excluir-convenio">';
            btnRemover += '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
            btnRemover += '</button>';
            tblContent += '<tr><td>' + (1 + key) + '</td><td>' + obj.convenio + '</td><td>' + btnRemover + '</td></tr>';
        });
        tblContent += '</tbody>';
        tblContent += '</table>';
    } else {
        var tblContent = '<div class="row">';
        tblContent += '<div class="col-md-12 text-center">';
        tblContent += '<b>Não há convênios cadastrados!</b>'
        tblContent += '</div>';
        tblContent += '</div>';
    }

    tblConvenios.append(tblContent);
}

$(document).ready(function() {
    // Busca os convenios do profissional
    getConveniosProfissional();

    // Listener do botão "+" (Adicinar mais convenios)
    $('#btnConvenioAdd').on('click', function() {
        // Popula o combo antes de exibir
        getConvenios();
        // Exibe "pseudo form" de inclusão
        $('#pnlConvenioAdd').fadeIn().removeClass('hidden');
    });

    // Listener do botão Cancelar, oculta "pseudo form" de inclusão
    $('#btnConvenioAddCancel').on('click', function() {
        $('#pnlConvenioAdd').fadeOut().addClass('hidden');
    });

    // Listener do botão Salvar, "pseduo form" de inclusão
    $('#btnConvenioAddSave').on('click', function() {
        addConvenioProfissional();
    });

    // Modal Confirma Exclusão de Convênio (Ajusta informações para exibir)
    $('#modal-excluir-convenio').on('show.bs.modal', function(e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        var convenio = btn.data('convenio');

        // Seta elementos da Modal (texto e id do convênio como data attribute do botão Excluir)
        var modal = $(this);
        modal.find('#btnExcluirConvenio').data('id_convenio', id);
        modal.find('.modal-body p').html('Confirma exclusão do convênio <b>' + convenio + '</b>');
    });

    // Modal Adicionar Convenio, limpa o input quando esconde
    $('#modal-adicionar-convenio').on('hidden.bs.modal', function(e) {
        $('#txtConvenioNovo').val('');
    });

    // Listener do botão Excluir da Modal de Exclusão de Convênio
    $('#btnExcluirConvenio').on('click', function() {
        var id = $(this).data('id_convenio');

        dropConvenioProfissional();
    });

    // Listener do botão Salvar da Modal Novo
    $('#btnSalvarConvenio').on('click', function() {
        addNewConvenioProfissional();
    });
});
