<!-- Modal Adicionar Especialidade -->
<div class="modal fade" id="modal-adicionar-especialidade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Adicionar Especialidade</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtEspecialidadeNovo">Nome</label>
                            <input type="text" class="form-control" id="txtEspecialidadeNovo" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarEspecialidade">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM: Modal Adicionar Especialidade -->

<!-- Modal Confirma Exclusão Especialidade -->
<div class="modal fade" id="modal-excluir-especialidade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;Atenção</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p style="padding-left:15px;">
                        Confirma exclusão da Especialidade
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnExcluirEspecialidade">Excluir</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM: Modal Confirma Exclusão Especialidade -->

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>Especialidades</b>
            <button class="btn btn-success btn-xs pull-right" id="btnEspecialidadeAdd">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
        {{-- Cadastro de novo convênio, aparece quando o botão + do header do panel é acionado --}}
        <div class="panel-body hidden" id="pnlEspecialidadeAdd">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="cboEspecialidade" class="control-label">Especialidade</label>
                        <select class="form-control" id="cboEspecialidade">
                            <option value=""></option>
                            {{-- @foreach ($especialidadesPessoa as $especialidadePessoa)
                                <option value="{{ $especialidadePessoa->id }}">{{ $especialidadePessoa->Especialidade->especialidade }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-adicionar-especialidade">Novo</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-default pull-right" id="btnEspecialidadeAddCancel">Cancelar</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary pull-right"  id="btnEspecialidadeAddSave">Salvar</button>
                </div>
            </div>
        </div>
        {{-- Tabela com os convênios atendidos --}}
        <div id="tblEspecialidades"></div>
    </div>
</div>
@push('scripts-footer')
    <script src="{{ asset('js/partials/profissional-especialidades.js') }}"></script>
@endpush
