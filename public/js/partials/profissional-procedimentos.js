function getProcedimentos() {
    $.ajax({
        type: 'GET',
        url: '/cadastro/busca/procedimentos',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            populaComboProcedimentos(data);
        },
        complete: function() {
            console.log('done!');
        }
    });
}

function getProcedimentosProfissional() {
    $.ajax({
        type: 'GET',
        url: '/cadastro/profissional/procedimentos',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            populaProcedimentos(data);
        },
        complete: function() {
            console.log('done!');
        }
    });
}

function addNewProcedimentoProfissional() {
    var nome = $('#txtProcedimentoNovo').val();
    var valor = $('#txtProcedimentoNovoValor').val();

    if (nome !== '' && valor !== '') {
        $.ajax({
            type: 'POST',
            url: 'profissional/procedimento/new',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { nome: nome, valor: valor },
            success: function(data) {
                getProcedimentosProfissional();
            },
            complete: function() {
                $('#modal-adicionar-procedimento').modal('hide');
                $('#pnlProcedimentoAdd').fadeOut().addClass('hidden');
            }
        });
    }
}

function addProcedimentoProfissional() {
    var idProcedimento = $('#cboProcedimento').val();
    var valor = $('#txtProcedimentoValor').val();

    if (idProcedimento !== '') {
        $.ajax({
            type: 'POST',
            url: '/cadastro/profissional/procedimento/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { idProcedimento: idProcedimento, valor: valor },
            success: function(data) {
                getProcedimentosProfissional();
            },
            complete: function() {
                $('#pnlProcedimentoAdd').fadeOut().addClass('hidden');
            }
        });
    }
}

function dropProcedimentoProfissional() {
    var idProcedimento = $('#btnExcluirProcedimento').data('id_procedimento');

    $.ajax({
        type: 'POST',
        url: '/cadastro/profissional/procedimento/drop',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { idProcedimento: idProcedimento },
        success: function(data) {
            getProcedimentosProfissional();
        },
        complete: function() {
            $('#modal-excluir-procedimento').modal('hide');
        }
    });
}

function alterProcedimentoProfissional() {
    var idProcedimento = $('#btnAlterarProcedimento').data('id_procedimento');
    var valor = $('#txtProcedimentoAlterarValor').val();

    if (idProcedimento !== '' && valor !== '') {
        $.ajax({
            type: 'POST',
            url: '/cadastro/profissional/procedimento/alter',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { idProcedimento: idProcedimento, valorNovo: valor },
            success: function(data) {
                getProcedimentosProfissional();
            },
            complete: function() {
                $('#modal-alterar-procedimento').modal('hide');
            }
        });
    }
}

function populaComboProcedimentos(procedimentos) {
    var cboProcedimento = $('#cboProcedimento');
    cboProcedimento.empty();

    $('<option />', { value: '', text: '' }).appendTo(cboProcedimento);
    $.each(procedimentos, function(key, obj) {
        $('<option />', { value: obj.id, text: obj.procedimento }).appendTo(cboProcedimento);
    });
}

function populaProcedimentos(data) {
    var procedimentos = JSON.parse(data);
    var tblProcedimentos = $('#tblProcedimentos');
    tblProcedimentos.empty();

    if (procedimentos.length) {
        var tblContent = '<table class="table table-condensed table-striped">';
        tblContent += '<thead><tr><th>#</th><th>Procedimento</th><th>Valor</th><th></th></tr></thead>';
        tblContent += '<tbody>';
        $.each(procedimentos, function(key, obj) {
            var btnAlterar = '<button type="button" class="btn btn-xs btn-primary btn-procedimento-alterar" aria-label="Left Align" data-id="' + obj.id + '" data-procedimento="' + obj.procedimento + '" data-valor="' + obj.valor + '" data-toggle="modal" data-target="#modal-alterar-procedimento">';
            btnAlterar += '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
            btnAlterar += '</button>&nbsp;';
            var btnRemover = '<button type="button" class="btn btn-xs btn-danger btn-procedimento-excluir" aria-label="Left Align" data-id="' + obj.id + '" data-procedimento="' + obj.procedimento + '" data-toggle="modal" data-target="#modal-excluir-procedimento">';
            btnRemover += '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
            btnRemover += '</button>';
            tblContent += '<tr><td>' + (1 + key) + '</td><td>' + obj.procedimento + '</td><td>' + obj.valor + '</td><td>' + btnAlterar + btnRemover + '</td></tr>';
        });
        tblContent += '</tbody>';
        tblContent += '</table>';
    } else {
        var tblContent = '<div class="row">';
        tblContent += '<div class="col-md-12 text-center">';
        tblContent += '<b>Não há procedimentos cadastrados!</b>'
        tblContent += '</div>';
        tblContent += '</div>';
    }

    tblProcedimentos.append(tblContent);
}

$(document).ready(function() {
    // Busca os procedimentos do profissional
    getProcedimentosProfissional();

    // Listener do botão "+" (Adicinar mais procedimentos)
    $('#btnProcedimentoAdd').on('click', function() {
        // Popula o combo antes de exibir
        getProcedimentos();
        // Limpa input de valor
        $('#txtProcedimentoValor').val('');
        // Exibe "pseudo form" de inclusão
        $('#pnlProcedimentoAdd').fadeIn().removeClass('hidden');
    });

    // Listener do botão Cancelar, oculta "pseudo form" de inclusão
    $('#btnProcedimentoAddCancel').on('click', function() {
        $('#pnlProcedimentoAdd').fadeOut().addClass('hidden');
    });

    // Listener do botão Salvar, "pseduo form" de inclusão
    $('#btnProcedimentoAddSave').on('click', function() {
        addProcedimentoProfissional();
    });

    // Modal Confirma Exclusão de Procedimento (Ajusta informações para exibir)
    $('#modal-excluir-procedimento').on('show.bs.modal', function(e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        var procedimento = btn.data('procedimento');

        // Seta elementos da Modal (texto e id do convênio como data attribute do botão Excluir)
        var modal = $(this);
        modal.find('#btnExcluirProcedimento').data('id_procedimento', id);
        modal.find('.modal-body p').html('Confirma exclusão do convênio <b>' + procedimento + '</b>');
    });

    // Modal Adicionar Procedimento, limpa os input quando esconde
    $('#modal-adicionar-procedimento').on('hidden.bs.modal', function(e) {
        $('#txtProcedimentoNovo').val('');
        $('#txtProcedimentoNovoValor').val('');
    });

    // Modal Alterar valor do Procedimento
    $('#modal-alterar-procedimento').on('show.bs.modal', function(e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        var procedimento = btn.data('procedimento');
        var valor = btn.data('valor');

        var modal = $(this);
        modal.find('#btnAlterarProcedimento').data('id_procedimento', id);
        modal.find('.modal-body p').html('<b>' + procedimento + ' - Valor Atual: R$ ' + valor + '</b>');
    });

    // Modal Alterar valor do Procedimento, limpa o input quando esconde
    $('#modal-alterar-procedimento').on('hidden.bs.modal', function(e) {
        $('#txtProcedimentoAlterarValor').val('');
    });

    // Listener do botão Excluir da Modal de Exclusão de Procedimento
    $('#btnExcluirProcedimento').on('click', function() {
        dropProcedimentoProfissional();
    });

    // Listener do botão Salvar da Modal de Alteração de Valor de Procedimento
    $('#btnAlterarProcedimento').on('click', function() {
        alterProcedimentoProfissional();
    });

    // Listener do botão Salvar da Modal Novo
    $('#btnSalvarProcedimento').on('click', function() {
        addNewProcedimentoProfissional();
    });
});
