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
        <form class="form-horizontal" id="frmCadastroAssistente" role="form" method="POST" action="{{ url('cadastro/profissional/assistente/store') }}">
            {{ csrf_field() }}
            {{-- Dados do Usuário --}}
            @include('partials.dados-usuario')
            {{--Dados do Assistente --}}
            @include('partials.dados-assistente')
            <hr />
            <button class="btn btn-primary" type="submit">Salvar Dados</button>
        </form>
    </div>
    <br />
    <br />

@stop
