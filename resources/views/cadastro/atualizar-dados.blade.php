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
        <form class="form-horizontal" id="frmAtualizarDados" role="form" method="POST" action="{{ url('cadastro/dados/atualizar') }}">
            {{ csrf_field() }}
            {{-- Dados do Usuário --}}
            @include('partials.dados-usuario-alterar')
            @if(session()->get('TIPO_PESSOA') === 'PP')
                {{--Dados do Paciente --}}
                @include('partials.dados-paciente-alterar')
                {{-- Dados de Endereço --}}
                @include('partials.dados-endereco-alterar')
                {{-- Telefone(s) --}}
                @include('partials.dados-telefone-alterar')
            @elseif (session()->get('TIPO_PESSOA') === 'PF')
                {{--Dados de Pessoa Física --}}
                @include('partials.dados-pessoafisica-alterar')
                {{-- Dados de Endereço --}}
                @include('partials.dados-endereco-alterar')
                {{-- Telefone(s) --}}
                @include('partials.dados-telefone-alterar')
            @elseif (session()->get('TIPO_PESSOA') === 'PJ')
                {{--Dados do Pessoa Juridica --}}
                @include('partials.dados-pessoajuridica-alterar')
                {{-- Dados de Endereço --}}
                @include('partials.dados-endereco-alterar')
                {{-- Telefone(s) --}}
                @include('partials.dados-telefone-alterar')
            @elseif (session()->get('TIPO_PESSOA') === 'PA')
                {{--Dados do Assistente --}}
                @include('partials.dados-assistente-alterar')
            @endif
            <hr />
            <button class="btn btn-primary" type="submit">Salvar Dados</button>
        </form>
    </div>
    <br />
    <br />

@stop
