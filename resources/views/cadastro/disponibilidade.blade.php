@extends('layouts.master')

@section('header')
    @include('layouts.menu')
@stop

@section('main')
    <div class="row">
        @if (session('error-msg'))
            <div class="alert alert-danger">
                {{ session('error-msg') }}
            </div>
        @endif
        <!-- Modal Adicionar Horario -->
        <div class="modal fade" id="modal-adicionar-horario" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Adicionar Horário Disponível</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="txtHorarioDisponivel">Horário</label>
                                    <input type="time" class="form-control" id="txtHorarioDisponivel" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="btnSalvarHorario">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM: Modal Adicionar Horario -->

        <!-- Modal Confirma Exclusão Horario -->
        <div class="modal fade" id="modal-excluir-horario" tabindex="-1" role="dialog">
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
                                Confirma exclusão do Horário
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btnExcluirHorario">Excluir</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM: Modal Confirma Exclusão Especialidade -->


        {{-- Dias da Semana - 1: Domingo - 7: Sabado --}}
        <h3>Cadastro de horários disponíveis</h3>
        <hr />
        <div class="row">
            <div class="col-md-2">
                <div class="row">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <b>Domingo</b><button class="btn btn-success btn-xs pull-right" data-dia="1" data-toggle="modal" data-target="#modal-adicionar-horario"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                        </div>
                        <div class="panel-body" id="tblDia01">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <b>Sábado</b><button class="btn btn-success btn-xs pull-right" data-dia="7" data-toggle="modal" data-target="#modal-adicionar-horario"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                        </div>
                        <div class="panel-body" id="tblDia07">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Segunda</b><button class="btn btn-success btn-xs pull-right" data-dia="2" data-toggle="modal" data-target="#modal-adicionar-horario"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                    </div>
                    <div class="panel-body" id="tblDia02">
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Terça</b><button class="btn btn-success btn-xs pull-right" data-dia="3" data-toggle="modal" data-target="#modal-adicionar-horario"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                    </div>
                    <div class="panel-body" id="tblDia03">
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Quarta</b><button class="btn btn-success btn-xs pull-right" data-dia="4" data-toggle="modal" data-target="#modal-adicionar-horario"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                    </div>
                    <div class="panel-body" id="tblDia04">
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Quinta</b><button class="btn btn-success btn-xs pull-right" data-dia="5" data-toggle="modal" data-target="#modal-adicionar-horario"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                    </div>
                    <div class="panel-body" id="tblDia05">
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Sexta</b><button class="btn btn-success btn-xs pull-right" data-dia="6" data-toggle="modal" data-target="#modal-adicionar-horario"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
                    </div>
                    <div class="panel-body" id="tblDia06">
                    </div>
                </div>
            </div>

        </div>
    </div>
    <br />
    <br />

    @push('scripts-footer')
        <script src="{{ asset('js/cadastro/disponibilidade.js') }}"></script>
    @endpush
@stop
