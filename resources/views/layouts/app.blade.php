@php
    header("Access-Control-Allow-Origin: *");
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    {{-- WYSIWYG Editor Integration --}}
    <script src="https://cdn.tiny.cloud/1/qtof8vieh1i6fqrfxu4nttn1nvoptxdmma913qe0911vkn5q/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fonts/ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/flaticon/font/flaticon.css') }}">
    <script src="https://kit.fontawesome.com/2e383d8019.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme_css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('theme_css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme_css/style.css') }}" rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    {{-- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> --}}
</head>
<body>
    
    <div id="app">
        <main class="py-4">
            @if (!Route::is('login') && !Route::is('register'))  
                @include('layouts.nav')
            @endif
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script src="{{ asset('theme_js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('theme_js/jquery-migrate-3.0.0.js') }}"></script>
    <script src="{{ asset('theme_js/popper.min.js') }}"></script>
    <script src="{{ asset('theme_js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('theme_js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('theme_js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('theme_js/jquery.stellar.min.js') }}"></script>

    <script src="{{ asset('theme_js/main.js') }}"></script>
</body>
</html>
