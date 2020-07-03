<h3>Telefone(s)</h3>
<hr />
<div id="divTelefones">
    @foreach($dados['telefones'] as $key => $telefone)
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-6 control-label">Tipo de Telefone</label>
                    <div class="col-md-6">
                        <select class="form-control" name="cboTipoTelefone[]">
                            @foreach ($dados['tiposTelefone'] as $tipoTelefone)
                                <option value="{{ $tipoTelefone->id }}" {{ ($telefone->tipoTelefone->id == $tipoTelefone->id) ? 'selected' : '' }} >{{ $tipoTelefone->tipo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-md-2 control-label">Número</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="txtNumeroTelefone[]" required maxlength="9" value="{{ $telefone->ddd . $telefone->numero }}" />
                    </div>
                    <div class="col-md-1">
                        @if ($key === 0)
                            <div class="btn btn-success" id="btnAdicionarTelefone" data-toggle="tooltip" data-placement="top" title="Clique aqui para adicionar mais telefones">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </div>
                        @else
                            <div class="btn btn-danger btn-remover-telefone" data-toggle="tooltip" data-placement="top" title="Clique aqui para remover telefone">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@push('scripts-footer')
    <script src="{{ asset('js/partials/dados-telefone.js') }}"></script>
@endpush
