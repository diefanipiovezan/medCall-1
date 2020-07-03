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
        <h3>Cadastro das informações profissionais</h3>
        <hr />
        <div class="row">
            {{-- Convênios do Profissional --}}
            @include('partials.profissional-convenios')
            {{-- Especialidades do Profissional--}}
            @include('partials.profissional-especialidades')
        </div>
        <div class="row">
            {{-- Procedimentos do Profissional --}}
            @include('partials.profissional-procedimentos')
        </div>
    </div>
    <br />
    <br />

@stop
