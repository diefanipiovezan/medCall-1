{{-- Agenda do paciente --}}
@extends('layouts.master')

@section('header')
    @include('layouts.menu')
@stop

@section('main')
    <!-- Modal Alerta -->
    <div class="modal fade" id="modal-alerta" tabindex="-1" role="dialog" data-message="abcd" data-id_agendamento="0" data-url="">
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
                    <button type="button" class="btn btn-default" id="btn-modal-alerta-submit">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM: Modal Alerta -->

    <!-- Modal Detalhes -->
    <div class="modal fade" id="modal-detalhes" tabindex="-2" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>&nbsp;Detalhes</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <p style="padding-left:15px;">
                            Blá blá blá....
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM: Modal Detalhes -->

    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Legenda</b></div>
                <div class="panel-body" style="pointer-events:none;">
                    <p><span class="glyphicon glyphicon-time" aria-hidden="true" style="color:orange;"></span>&nbsp;Aguardando Aprovação</p>
                    <p><span class="glyphicon glyphicon-ok" aria-hidden="true" style="color:green;"></span>&nbsp;Agendado</p>
                    <p><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:blue;"></span>&nbsp;Cancelado</p>
                    <p><span class="glyphicon glyphicon-remove" aria-hidden="true" style="color:red;"></span>&nbsp;Cancelado pelo Profissional</p>
                    <hr />
                    <p><button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-list" aria-hidden="true"></span></button>&nbsp;&nbsp;Detalhes</p>
                    <p><button class="btn btn-xs btn-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>&nbsp;&nbsp;Cancelar</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            {{-- Exibe tabela com os agendamentos do Profissional --}}
            <div id="tblAngedaPaciente" style="display:none;"></div>
        </div>
    </div>
    @push('scripts-footer')
        <script src="{{ asset('js/agenda/paciente.js') }}"></script>
    @endpush
@stop

{{--
@section('footer')
   &copy; Medcall Consultas
@stop
--}}
