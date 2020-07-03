@extends('layouts.master')

@section('header')
    @include('layouts.menu')
@stop

@section('main')
    <!-- Modal Alerta -->
    <div class="modal fade" id="modal-alerta" tabindex="-1" role="dialog" data-message="abcd" data-id_assistente="0">
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
                    <button type="button" class="btn btn-primary" id="btn-modal-alerta-submit">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM: Modal Alerta -->

    <div class="row">
        @if (session('error-msg'))
            <div class="alert alert-danger">
                {{ session('error-msg') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-10">
                <h3>Cadastro de Assistentes</h3>
            </div>
            <div class="col-md-2">
                <a href="/cadastro/profissional/assistente" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Novo</a>
            </div>
        </div>
        <hr />
        <div id="tblAssistentes" style="display: none;">
        </div>
    </div>
    @push('scripts-footer')
        <script src="{{ asset('js/cadastro/assistentes.js') }}"></script>
    @endpush
@stop
