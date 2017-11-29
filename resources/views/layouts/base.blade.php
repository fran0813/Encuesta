<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Admin') }}</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" >
    {{-- Css --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    <div id="app">        
        @yield('navbar')           

        @yield('content')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- Scripts -->
    @yield('javascript')
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
</body>
</html>