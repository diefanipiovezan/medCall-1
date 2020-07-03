<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{-- <a class="navbar-brand" href="#">Medcall Consultas</a> --}}
            <a class="pull-left" href="{{ url('/') }}"><img src="{{ url('/images/logo1.png') }}" width="122px" /></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    {{-- Profissional --}}
                    @if (session()->get('TIPO_PESSOA') === 'PF' || session()->get('TIPO_PESSOA') === 'PJ')
                        <li><a href="{{ url('/agenda/profissional') }}"><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;Agenda</a></li>
                        <li><a href="{{ url('/cadastro/profissional/disponibilidade') }}"><span class="glyphicon glyphicon-time"></span>&nbsp;&nbsp;Disponibilidade</a></li>
                        <li><a href="{{ url('/cadastro/profissional') }}"><span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;Profissional</a></li>
                        <li><a href="{{ url('/cadastro/profissional/assistentes') }}"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Assistentes</a></li>
                    {{-- Assistente --}}
                    @elseif (session()->get('TIPO_PESSOA') === 'PA')
                        <li><a href="{{ url('/agenda/profissional') }}"><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;Agenda</a></li>
                    {{-- Paciente --}}
                    @elseif (session()->get('TIPO_PESSOA') === 'PP')
                        <li><a href="{{ url('/') }}"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Pesquisa</a></li>
                        <li><a href="{{ url('/agenda/paciente') }}"><span class="glyphicon glyphicon-calendar"></span>&nbsp;&nbsp;Agenda</a></li>
                    @endif
                    <li><a href="{{ url('/cadastro/dados/atualizar') }}"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;Configurações</a></li>
                    <li><a href="{{ route('logout') }}"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
                @else
                    <li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Login</a></li>
                @endif
                <li><a href="#"><span class="glyphicon glyphicon-info-sign"></span>&nbsp;&nbsp;Sobre</a></li>
            </ul>
        </div>
    </div>
</nav>
