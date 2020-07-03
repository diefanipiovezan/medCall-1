<h3>Telefone(s)</h3>
<hr />
<div id="divTelefones">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-6 control-label">Tipo de Telefone</label>
                <div class="col-md-6">
                    <select class="form-control" name="cboTipoTelefone[]">
                        @foreach ($tiposTelefone as $tipoTelefone)
                            <option value="{{ $tipoTelefone->id }}">{{ $tipoTelefone->tipo }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-md-2 control-label">Número</label>
                <div class="col-md-6">
                    <input type="number" class="form-control" name="txtNumeroTelefone[]" required maxlength="9" />
                </div>
                <div class="col-md-1">
                    <div class="btn btn-success" id="btnAdicionarTelefone" data-toggle="tooltip" data-placement="top" title="Clique aqui para adicionar mais telefones">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts-footer')
    <script src="{{ asset('js/partials/dados-telefone.js') }}"></script>
@endpush
