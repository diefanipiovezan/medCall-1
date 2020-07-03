function getEspecialidade() {
    $.ajax({
        type: 'GET',
        url: '/cadastro/busca/especialidades',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            populaComboEspecialidade(data);
        },
        complete: function() {
            console.log('done!');
        }
    });
}

function getEspecialidadeProfissional() {
    $.ajax({
        type: 'GET',
        url: '/cadastro/profissional/especialidades',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            populaEspecialidade(data);
        },
        complete: function() {
            console.log('done!');
        }
    });
}

function addNewEspecialidadeProfissional() {
    var nome = $('#txtEspecialidadeNovo').val();

    if (nome !== '') {
        $.ajax({
            type: 'POST',
            url: 'profissional/especialidade/new',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { nome: nome },
            success: function(data) {
                getEspecialidadeProfissional();
            },
            complete: function() {
                $('#modal-adicionar-especialidade').modal('hide');
                $('#pnlEspecialidadeAdd').fadeOut().addClass('hidden');
            }
        });
    }
}

function addEspecialidadeProfissional() {
    var idEspecialidade = $('#cboEspecialidade').val();

    if (idEspecialidade !== '') {
        $.ajax({
            type: 'POST',
            url: '/cadastro/profissional/especialidade/add',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { idEspecialidade: idEspecialidade },
            success: function(data) {
                getEspecialidadeProfissional();
            },
            complete: function() {
                $('#pnlEspecialidadeAdd').fadeOut().addClass('hidden');
            }
        });
    }
}

function dropEspecialidadeProfissional() {
    var idEspecialidade = $('#btnExcluirEspecialidade').data('id_especialidade');

    $.ajax({
        type: 'POST',
        url: '/cadastro/profissional/especialidade/drop',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { idEspecialidade: idEspecialidade },
        success: function(data) {
            getEspecialidadeProfissional();
        },
        complete: function() {
            $('#modal-excluir-especialidade').modal('hide');
        }
    });
}

function populaComboEspecialidade(especialidades) {
    var cboEspecialidade = $('#cboEspecialidade');
    cboEspecialidade.empty();

    $('<option />', { value: '', text: '' }).appendTo(cboEspecialidade);
    $.each(especialidades, function(key, obj) {
        $('<option />', { value: obj.id, text: obj.especialidade }).appendTo(cboEspecialidade);
    });
}

function populaEspecialidade(data) {
    var especialidades = JSON.parse(data);
    var tblEspecialidades = $('#tblEspecialidades');
    tblEspecialidades.empty();

    if (especialidades.length) {
        var tblContent = '<table class="table table-condensed table-striped">';
        tblContent += '<thead><tr><th>#</th><th>Especialidade</th><th></th></tr></thead>';
        tblContent += '<tbody>';
        $.each(especialidades, function(key, obj) {
            var btnRemover = '<button type="button" class="btn btn-xs btn-danger btn-especialidade-excluir" aria-label="Left Align" data-id="' + obj.id + '" data-especialidade="' + obj.especialidade + '" data-toggle="modal" data-target="#modal-excluir-especialidade">';
            btnRemover += '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
            btnRemover += '</button>';
            tblContent += '<tr><td>' + (1 + key) + '</td><td>' + obj.especialidade + '</td><td>' + btnRemover + '</td></tr>';
        });
        tblContent += '</tbody>';
        tblContent += '</table>';
    } else {
        var tblContent = '<div class="row">';
        tblContent += '<div class="col-md-12 text-center">';
        tblContent += '<b>Não há especialidades cadastradas!</b>'
        tblContent += '</div>';
        tblContent += '</div>';
    }

    tblEspecialidades.append(tblContent);
}

$(document).ready(function() {
    // Busca os especialidades do profissional
    getEspecialidadeProfissional();

    // Listener do botão "+" (Adicinar mais especialidades)
    $('#btnEspecialidadeAdd').on('click', function() {
        // Popula o combo antes de exibir
        getEspecialidade();
        // Exibe "pseudo form" de inclusão
        $('#pnlEspecialidadeAdd').fadeIn().removeClass('hidden');
    });

    // Listener do botão Cancelar, oculta "pseudo form" de inclusão
    $('#btnEspecialidadeAddCancel').on('click', function() {
        $('#pnlEspecialidadeAdd').fadeOut().addClass('hidden');
    });

    // Listener do botão Salvar, "pseduo form" de inclusão
    $('#btnEspecialidadeAddSave').on('click', function() {
        addEspecialidadeProfissional();
    });

    // Modal Confirma Exclusão de Convênio (Ajusta informações para exibir)
    $('#modal-excluir-especialidade').on('show.bs.modal', function(e) {
        var btn = $(e.relatedTarget);
        var id = btn.data('id');
        var especialidade = btn.data('especialidade');

        // Seta elementos da Modal (texto e id do convênio como data attribute do botão Excluir)
        var modal = $(this);
        modal.find('#btnExcluirEspecialidade').data('id_especialidade', id);
        modal.find('.modal-body p').html('Confirma exclusão da especialidade <b>' + especialidade + '</b>');
    });

    // Modal Adicionar Especialidade, limpa o input quando esconde
    $('#modal-adicionar-especialidade').on('hidden.bs.modal', function(e) {
        $('#txtEspecialidadeNovo').val('');
    });

    // Listener do botão Excluir da Modal de Exclusão de Convênio
    $('#btnExcluirEspecialidade').on('click', function() {
        var id = $(this).data('id_especialidade');

        dropEspecialidadeProfissional();
    });

    // Listener do botão Salvar da Modal Novo
    $('#btnSalvarEspecialidade').on('click', function() {
        addNewEspecialidadeProfissional();
    });
});
