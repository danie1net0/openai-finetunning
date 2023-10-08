<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  <body class="h-full">
    @hasSection('content')
      @yield('content')
    @endif

    @livewireScriptConfig
  </body>
</html>
