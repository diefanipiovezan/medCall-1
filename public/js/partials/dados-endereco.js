function populaCidades(cidades) {
    var cboCidade = $('#cboCidade');
    cboCidade.empty();

    $('<option />', { value: '', text: '' }).appendTo(cboCidade);
    $.each(cidades, function(key, obj) {
        $('<option />', { value: obj.id, text: obj.nome }).appendTo(cboCidade);
    });
}

function populaBairros(bairros) {
    var cboBairro = $('#cboBairro');
    cboBairro.empty();

    $('<option />', { value: '', text: '' }).appendTo(cboBairro);
    $.each(bairros, function(key, obj) {
        $('<option />', { value: obj.id, text: obj.nome }).appendTo(cboBairro);
    });
}

function buscaCidades(idEstado) {
    $('#cboBairro').empty();
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
}

function buscaBairros(idCidade) {
    $.ajax({
        type: 'GET',
        url: '/cadastro/busca/bairros',
        data: { idCidade: idCidade },
        success: function(data) {
            populaBairros(data);
        },
        error: function(err) {
            // TODO: Tratar erro
            console.log(err);
        }
    });
}

// Combo de Estado
$('#cboEstado').on('change', function() {
    $('#cboCidade').empty();
    $('#cboBairro').empty();

    // Busca cidades pelo Combo de Estado selecionado
    var idEstado = $(this).val();

    if (idEstado !== '') {
        buscaCidades(idEstado);
    }
});

// Combo de Cidade
$('#cboCidade').on('change', function() {
    $('#cboBairro').empty();

    // Busca bairros pelo Combo de Cidade selecionado
    var idCidade = $(this).val();

    if (idCidade !== '') {
        buscaBairros(idCidade);
    }
});

// Botão Adicionar Cidade
$('#btnAdicionarCidade').on('click', function() {
    var idEstado = $('#cboEstado').val();

    if (idEstado !== '') {
        $('#modal-adicionar-cidade').modal('show');
    }
});

// Botão Adicionar Bairro
$('#btnAdicionarBairro').on('click', function() {
    var idCidade = $('#cboCidade').val();

    if (idCidade !== '') {
        $('#modal-adicionar-bairro').modal('show');
    }
});

// Botão Salvar Cidade
$('#btnSalvarCidade').on('click', function() {
    var nome = $('#txtCidadeNova').val();

    if (nome !== '') {
        var idEstado = $('#cboEstado').val();
        var cboCidade = $('#cboCidade');

        $.ajax({
            type: 'POST',
            url: '/cadastro/salvar/cidade',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { idEstado: idEstado, nome: nome },
            success: function(data) {
                // console.log(data);
                buscaCidades(idEstado);
            },
            complete: function() {
                $('#modal-adicionar-cidade').modal('hide');
            }
        });
    }
});

// Botão Salvar Bairro
$('#btnSalvarBairro').on('click', function() {
    var nome = $('#txtBairroNovo').val();

    if (nome !== '') {
        var idCidade = $('#cboCidade').val();
        var cboBairro = $('#cboBairro');

        $.ajax({
            type: 'POST',
            url: '/cadastro/salvar/bairro',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { idCidade: idCidade, nome: nome },
            success: function(data) {
                // console.log(data);
                buscaBairros(idCidade);
            },
            complete: function() {
                $('#modal-adicionar-bairro').modal('hide');
            }
        });
    }
});
