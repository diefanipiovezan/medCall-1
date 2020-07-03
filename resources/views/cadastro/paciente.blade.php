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
        <form class="form-horizontal" id="frmCadastroPaciente" role="form" method="POST" action="{{ url('cadastro/paciente/store') }}">
            {{ csrf_field() }}
            {{-- Dados do Usuário --}}
            @include('partials.dados-usuario')
            {{--Dados do Paciente --}}
            @include('partials.dados-paciente')
            {{-- Dados de Endereço --}}
            @include('partials.dados-endereco')
            {{-- Telefone(s) --}}
            @include('partials.dados-telefone')
            <hr />
            <button class="btn btn-primary" type="submit">Salvar Dados</button>
        </form>
    </div>
    <br />
    <br />

@stop
