<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>
        body{
            font-family: "DM Sans", sans-serif !important;
        }
        .datatable{
            border: 1px solid #eee !important;
        }
    </style>
    @include('stylesheet')

</head>
<body>
    <div id="loading-wrapper">
        <div class='spinner-wrapper'>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
            <div class='spinner'>
                <div class='inner'></div>
            </div>
        </div>
    </div>
    @if(Auth::user())
        @include('header')
    @endif
    <div class="container-fluid">
        @if(Auth::user())
            @if(Auth::user()->user_type == "admin")
                @include('admintopbar')
            @elseif(Auth::user()->user_type == "doctor")
                @include('doctortopbar')
            @elseif(Auth::user()->user_type == "reception")
                @include('receptiontopbar')
            @endif
        @endif
        <div class="main-container">
            @yield('content')
            
        </div>
        @include('footer') 
    </div>
    
    
</body>


@include('javascript')

{{-- page script --}}
@yield('page-script')
{{-- page script --}}
</html>
