<!-- Modal Criar Cidade -->
<div class="modal fade" id="modal-adicionar-cidade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Adicionar Cidade</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="txtCidadeNova">Nome</label>
                            <input type="text" class="form-control" id="txtCidadeNova" maxlength="60" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarCidade">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM: Modal Criar Cidade -->

<!-- Modal Criar Bairro -->
<div class="modal fade" id="modal-adicionar-bairro" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Adicionar Bairro</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <label for="txtBairroNovo">Nome</label>
                            <input type="text" class="form-control" id="txtBairroNovo" maxlength="60" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarBairro">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM: Modal Criar Bairro -->

<h3>Endereço</h3>
<hr />
<div class="form-group">
    <label for="cboEstado" class="col-md-2 control-label">Estado</label>
    <div class="col-md-2">
        <select class="form-control" name="cboEstado" id="cboEstado" required>
            <option value=""></option>
            @foreach ($dados['estados'] as $estado)
                <option value="{{ $estado->id }}" {{ ($estado->id == $dados['cidade']->id_estado) ? 'selected' : '' }}>{{ $estado->nome }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="cboCidade" class="col-md-2 control-label">Cidade</label>
    <div class="col-md-4">
        <select class="form-control" name="cboCidade" id="cboCidade" required>
            {{-- Conteúdo carrega via Ajax no change do Combo Superior --}}
            <option value=""></option>
            @foreach ($dados['cidades'] as $cidade)
                <option value="{{ $cidade->id }}" {{ ($cidade->id == $dados['cidade']->id) ? 'selected' : '' }}>{{ $cidade->nome }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-1">
        <div class="btn btn-success" id="btnAdicionarCidade" {{--data-toggle="modal" data-target="#modal-adicionar-cidade"--}}>
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="cboBairro" class="col-md-2 control-label">Bairro</label>
    <div class="col-md-4">
        <select class="form-control" name="cboBairro" id="cboBairro" required>
            {{-- Conteúdo carrega via Ajax no change do Combo Superior --}}
            <option value=""></option>
            @foreach ($dados['bairros'] as $bairro)
                <option value="{{ $bairro->id }}" {{ ($bairro->id == $dados['bairro']->id) ? 'selected' : '' }}>{{ $bairro->nome }}</option>
            @endforeach

        </select>
    </div>
    <div class="col-md-1">
        <div class="btn btn-success" id="btnAdicionarBairro" {{--data-toggle="modal" data-target="#modal-adicionar-bairro"--}}>
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
        </div>
    </div>
</div>
<div class="form-group">
    <label for="txtLogradouro" class="col-md-2 control-label">Logradouro</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="txtLogradouro" placeholder="Ex.: Rua Tom Jobim" maxlength="60" required value="{{ $dados['logradouro']->nome }}" />
    </div>
</div>
<div class="form-group">
    <label for="txtNumero" class="col-md-2 control-label">Número</label>
    <div class="col-md-2">
        <input type="number" class="form-control" name="txtNumero" maxlength="5" value="{{ $dados['logradouro']->numero }}" />
    </div>
</div>
<div class="form-group">
    <label for="txtCep" class="col-md-2 control-label">CEP</label>
    <div class="col-md-2">
        <input type="number" class="form-control" name="txtCep" maxlength="8" value="{{ $dados['logradouro']->cep }}" />
    </div>
</div>
<div class="form-group">
    <label for="txtComplemento" class="col-md-2 control-label">Complemento</label>
    <div class="col-md-5">
        <input type="text" class="form-control" name="txtComplemento" maxlength="60" value="{{ $dados['logradouro']->complemento }}" />
    </div>
</div>
@push('scripts-footer')
    <script src="{{ asset('js/partials/dados-endereco.js') }}"></script>
@endpush
