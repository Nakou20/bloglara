<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Plateforme de Blogging Moderne</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>

    <body class="antialiased font-sans bg-white dark:bg-gray-900">
        <!-- Header Navigation -->
        <nav class="fixed top-0 w-full bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Left side - Boutons -->
                    <div class="flex items-center space-x-6">
                        @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="px-6 py-2.5 text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-semibold transition-colors duration-200">
                                    Se connecter
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                        S'inscrire
                                    </a>
                                @endif

                        @endif
                    </div>

                    <!-- Right side - Logo -->
                    <div class="flex items-center">
                        <x-application-logo class="h-12 w-auto text-indigo-600 dark:text-indigo-400 fill-current" />
                    </div>
                </div>
            </div>
        </nav>


