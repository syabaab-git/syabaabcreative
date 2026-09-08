<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Syabaab Creative') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-apple-parchment text-apple-ink dark:bg-black dark:text-slate-100 flex flex-col min-h-screen pb-[calc(6rem+env(safe-area-inset-bottom))] sm:pb-0 transition-colors duration-300">
        
        <!-- Global Nav (Admin Dashboard Style) -->
        @include('layouts.navigation')

        <!-- Main Content (Padding added for global nav) -->
        <main class="flex-grow {{ request()->routeIs('landing') ? 'pt-0' : 'pt-[105px]' }}">
            {{ $slot }}
        </main>

    </body>
</html>
