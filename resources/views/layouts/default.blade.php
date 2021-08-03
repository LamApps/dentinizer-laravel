<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <style>
        .form-label{
            color:#000;
            font-weight: 600;
        }
        body{
            font-family: "DM Sans", sans-serif !important;
        }
        .datatable{
            border: 1px solid #eee !important;
        }
    </style>
</head>
<body class="authentication" style="background-position: center;   background-size: cover;">
    <div class="container">
    @yield('content')
    </div>
    
    
</body>

</html>
