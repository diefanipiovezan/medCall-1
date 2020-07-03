<!-- Modal Adicionar Procedimento -->
<div class="modal fade" id="modal-adicionar-procedimento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Adicionar Procedimento</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtProcedimentoNovo">Nome</label>
                            <input type="text" class="form-control" id="txtProcedimentoNovo" />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtProcedimentoNovoValor">Valor</label>
                            <input type="number" class="form-control" id="txtProcedimentoNovoValor" min="0" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarProcedimento">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM: Modal Adicionar Procedimento -->

<!-- Modal Alterar Valor Procedimento -->
<div class="modal fade" id="modal-alterar-procedimento" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Alterar Valor do Procedimento</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>Procedimento asdfsdaf, Valor atual: R$ 300,00</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txtProcedimentoAlterarValor">Novo Valor</label>
                            <div class="input-group">
                                <span class="input-group-addon">R$</span>
                                <input type="number" class="form-control" id="txtProcedimentoAlterarValor" min="0" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnAlterarProcedimento">Salvar</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM: Modal Alterar Valor Procedimento -->


<!-- Modal Confirma Exclusão Procedimento -->
<div class="modal fade" id="modal-excluir-procedimento" tabindex="-1" role="dialog">
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
                        Confirma exclusão do Procedimento
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnExcluirProcedimento">Excluir</button>
            </div>
        </div>
    </div>
</div>
<!-- FIM: Modal Confirma Exclusão Procedimento -->

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <b>Procedimentos</b>
            <button class="btn btn-success btn-xs pull-right" id="btnProcedimentoAdd">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
        {{-- Cadastro de novo procedimento, aparece quando o botão + do header do panel é acionado --}}
        <div class="panel-body hidden" id="pnlProcedimentoAdd">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="cboProcedimento" class="control-label">Procedimento</label>
                        <select class="form-control" id="cboProcedimento">
                            <option value=""></option>
                            {{-- @foreach ($procedimentosPessoa as $procedimentoPessoa)
                                <option value="{{ $procedimentoPessoa->id }}">{{ $procedimentoPessoa->Procedimento->procedimento }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="txtProcedimentoValor" class="control-label">Valor</label>
                        <input type="number" class="form-control" id="txtProcedimentoValor" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal-adicionar-procedimento">Novo</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-default pull-right" id="btnProcedimentoAddCancel">Cancelar</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary pull-right"  id="btnProcedimentoAddSave">Salvar</button>
                </div>
            </div>
        </div>
        {{-- Tabela com os procedimentos atendidos --}}
        <div id="tblProcedimentos"></div>
    </div>
</div>
@push('scripts-footer')
    <script src="{{ asset('js/partials/profissional-procedimentos.js') }}"></script>
@endpush
