<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <title>Medcall Consultas</title>
        <!-- Twitter Bootstap -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/master.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container" id="main-container">
            <div class="header">
                @yield('header')
            </div>
            <div class="main">
                @yield('main')
            </div>
            <div class="footer">
                @yield('footer')
            </div>
        </div>
        <!--Javascript (jQuery and Bootstrap) -->
        <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        @stack('scripts-footer')
    </body>
</html>
