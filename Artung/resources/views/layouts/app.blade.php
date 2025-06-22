<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Artung') }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
  <div class="min-h-screen flex bg-cyan-100">
    {{-- Conteúdo principal --}}
    <main class="flex-1 overflow-auto p-6">
      @if (isset($header))
        <header class="mb-6">
          {{ $header }}
        </header>
      @endif

      @yield('content')
    </main>

    {{-- Sidebar direita fixa --}}
    <aside class="w-64 bg-cyan-200 border-l border-gray-300">
      @include('layouts.navigation')
    </aside>
  </div>
</body>
</html>
