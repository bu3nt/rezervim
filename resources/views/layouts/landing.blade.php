<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="Butrint Babuni">
    <meta name="description" content="Një platformë e përsosur për të bërë rezervime online me lehtësi dhe shpejtësi!">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Open Graph Tags -->
    <meta property="og:title" content="{{ config('app.name', 'Laravel') }}">
    <meta property="og:description" content="Një platformë e përsosur për të bërë rezervime online me lehtësi dhe shpejtësi!">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:image" content="{{ asset('assets/images/logo/logo.png') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">
    <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">    
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