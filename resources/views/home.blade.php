@extends('layouts.master')

@section('header')
    @include('layouts.menu')
@stop

@section('main')
    <!-- Modal Alerta -->
    <div class="modal fade" id="modal-alerta" tabindex="-2" role="dialog" data-message="abcd">
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
                            Atenção
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM: Modal Alerta -->

    <!-- Modal Agendamento -->
    <div class="modal fade" id="modal-agendamento" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- FIM: Modal Agendamento -->

    <div class="row">
        <!-- Pesuisa -->
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Busca de Profissionais</b></div>
                <div class="panel-body">
                    <form>
                        <!-- Estado -->
                        <div class="form-group">
                            <label for="cboEstado">Estado</label>
                            <select class="form-control" id="cboEstado">
                                <option value=""></option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}">{{ $estado->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Cidade -->
                        <div class="form-group">
                            <label for="cboCidade">Cidade</label>
                            <select class="form-control" id="cboCidade">
                            </select>
                        </div>
                        <!-- Especialidade -->
                        <div class="form-group">
                            <label for="cboEspecialidade">Especialidade</label>
                            <select class="form-control" id="cboEspecialidade">
                            </select>
                        </div>
                        <!-- Procedimento -->
                        <div class="form-group">
                            <label for="cboProcedimento">Procedimento</label>
                            <select class="form-control" id="cboProcedimento">
                            </select>
                        </div>
                        <!-- Convenio -->
                        <div class="form-group">
                            <label for="cboConvenio">Convênio</label>
                            <select class="form-control" id="cboConvenio">
                            </select>
                        </div>
                        <!-- Botao Pesquisar -->
                        <button type="submit" class="btn btn-success" id="btnPesquisar">
                            <span class="glyphicon glyphicon-search"></span>
                            &nbsp;Pesquisar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!-- FIM: Pesuisa -->
        <!-- Resultado Pesquisa -->
        <div class="col-md-9">
            <img id="bgMedcall" src="images/bg_medcall.jpg" class="img-responsive img-rounded pull-right" alt="Medcall" style="width:80%;">
            {{-- Exibe resultado da pesquisa com base nos filtros --}}
            <div id="tblProfissionaisDisponiveis" style="display:none;"></div>
            {{-- Exibe detalhes do profissional --}}
            <div id="tblDetalhesProfissional" style="display:none;"></div>
            {{-- Exibe horários do profissional selecionado na div anterior --}}
            <div id="tblHorariosProfissional" style="display:none;"></div>
        </div>
    </div>
    <!-- Ancora back to top -->
    <a href="#" id="back-to-top" class="btn btn-success back-to-top"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>
    @push('scripts-footer')
        <script src="{{ asset('js/agenda.js') }}"></script>
        <script src="{{ asset('js/back-to-top.js') }}"></script>
    @endpush
@stop

{{--
@section('footer')
   &copy; Medcall Consultas
@stop
--}}
