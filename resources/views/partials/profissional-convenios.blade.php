<!-- Modal Adicionar Convenio -->
<div class="modal fade" id="modal-adicionar-convenio" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Adicionar Convenio</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtConvenioNovo">Nome</label>
                            <input type="text" class="form-control" id="txtConvenioNovo" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarConvenio">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM: Modal Adicionar Convenio -->

<!-- Modal Confirma Exclusão Convenio -->
<div class="modal fade" id="modal-excluir-convenio" tabindex="-1" role="dialog">
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
                        Confirma exclusão do Convênio
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnExcluirConvenio">Excluir</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM: Modal Confirma Exclusão Convenio -->

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>Convênios atendidos</b>
            <button class="btn btn-success btn-xs pull-right" id="btnConvenioAdd">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
        {{-- Cadastro de novo convênio, aparece quando o botão + do header do panel é acionado --}}
        <div class="panel-body hidden" id="pnlConvenioAdd">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="cboConvenio" class="control-label">Convênio</label>
                        <select class="form-control" id="cboConvenio">
                            <option value=""></option>
                            {{-- @foreach ($conveniosPessoa as $convenioPessoa)
                                <option value="{{ $convenioPessoa->id }}">{{ $convenioPessoa->Convenio->convenio }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-adicionar-convenio">Novo</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-default pull-right" id="btnConvenioAddCancel">Cancelar</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary pull-right"  id="btnConvenioAddSave">Salvar</button>
                </div>
            </div>
        </div>
        {{-- Tabela com os convênios atendidos --}}
        <div id="tblConvenios"></div>
    </div>
</div>
@push('scripts-footer')
    <script src="{{ asset('js/partials/profissional-convenios.js') }}"></script>
@endpush
