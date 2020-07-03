<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title"><span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span>&nbsp;Agendar</h4>
</div>
<form name="frmAgendar">
    <div class="modal-body">
        <input type="hidden" name="txtIdProfissional" value="{{ $id_profissional }}"  />
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txtDia">Dia</label>
                    <input type="text" name="txtDia" class="form-control" readonly="true" value="{{ $dia }}" />
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txtHorario">Horário</label>
                    <input type="text" name="txtHorario" class="form-control" readonly="true" value="{{ $horario }}" />
                </div>
            </div>
            <div class="col-md-4 col-md-offset-2">
                <div class="form-group group-forma-pagamento" style="display:none;">
                    <label for="txtValor">Valor</label>
                    <div class="input-group">
                        <div class="input-group-addon">R$</div>
                        <input type="text" name="txtValor" class="form-control" readonly="true" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="cboProcedimentoAgendar">Procedimento</label>
                    <select class="form-control" name="cboProcedimentoAgendar" required>
                        <option value=""></option>
                        @foreach ($procedimentos as $procedimento)
                            <option value="{{ $procedimento->id }}" data-valor="{{ $procedimento->valor }}">{{ $procedimento->procedimento }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="cboContratacaoAgendar">Forma de Contratação</label>
                    <select class="form-control" name="cboContratacaoAgendar" required>
                        <option value=""></option>
                        <option value="1">Convênio Médico</option>
                        <option value="2">Pagamento</option>
                        </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group group-forma-pagamento" style="display:none;">
                    <label for="cboFormaPagamentoAgendar">Forma de Pagamento</label>
                    <select class="form-control" name="cboFormaPagamentoAgendar">
                        <option value=""></option>
                        <option value="1">Dinheiro</option>
                        <option value="2">Crédito</option>
                        <option value="3">Débito</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group group-convenio" style="display:none;">
                    <label for="cboConvenioAgendar">Convênio Médico</label>
                    <select class="form-control" name="cboConvenioAgendar">
                        <option value=""></option>
                        @foreach ($convenios as $convenio)
                            <option value="{{ $convenio->id }}">{{ $convenio->convenio }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
</form>
