@extends('layouts.master')

@section('header')
    @include('layouts.menu')
@stop

@section('main')
    <!-- Modal Criar Conta -->
    <div class="modal fade" id="modal-tipo-conta" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Escolha o tipo de conta</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">
                            <a href="{{ url('cadastro/paciente')}}">Paciente</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">
                            <a href="{{ url('cadastro/pessoafisica') }}">Profissional Pessoa Física</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11 col-md-offset-1">
                            <a href="{{ url('cadastro/pessoajuridica') }}">Profissional Pessoa Jurídica</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- FIM: Modal Criar Conta -->

    <div class="row">
        @if (session('error-msg'))
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-danger">
                    {{ session('error-msg') }}
                </div>
            </div>
        @endif
        @if (session('success-msg'))
            <div class="col-md-4 col-md-offset-4">
                <div class="alert alert-success">
                    {{ session('success-msg') }}
                </div>
            </div>
        @endif
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Login
                </div>
                <div class="panel-body">
                    <form id="frmLogin" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="username">Usuário</label>
                            <input type="text" class="form-control" name="username" />
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" name="password" />
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Entrar
                        </button>
                    </form>
                </div>
                <div class="panel-footer">
                    Não possui acesso? <a href="#modal-tipo-conta" data-toggle="modal" data-target="#modal-tipo-conta">Crie sua conta</a>
                </div>
            </div>
        </div>
    </div>
@stop
