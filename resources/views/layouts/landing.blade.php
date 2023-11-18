<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link
    rel="shortcut icon"
    href="{{ asset('assets/images/logo/favicon.ico') }}"
    type="image/x-icon"
    />

    <link rel="stylesheet" href="{{ asset('build/assets/css/animate.css') }}" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- ==== WOW JS ==== -->
    <script src="{{ asset('build/assets/js/wow.min.js') }}"></script>
    <script>
    new WOW().init();
    </script>    
  </head>
  <body>
    @include('layouts.navigation')
{{ $slot }}
  </body>
</html>