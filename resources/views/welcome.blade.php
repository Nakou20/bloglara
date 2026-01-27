<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <body class="antialiased font-sans bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-gray-950 dark:via-slate-900 dark:to-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
        <!-- Header Navigation -->
        <nav class="fixed top-0 w-full bg-white/90 dark:bg-gray-900/90 backdrop-blur-lg border-b border-gray-200/60 dark:border-gray-700/60 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    <!-- Left side - Logo -->
                    <div class="flex items-center">
                        <a href="/" class="flex items-center gap-2.5 group">
                            <x-application-logo class="h-9 w-auto text-indigo-600 dark:text-indigo-400 fill-current transition-transform duration-300 ease-out group-hover:scale-110" />
                            <span class="font-bold text-lg lg:text-xl text-gray-900 dark:text-white tracking-tight">BlogLara</span>
                        </a>
                    </div>

                    <!-- Right side - Actions -->
                    <div class="flex items-center gap-3 lg:gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                                    Espace Auteur
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                                    Se connecter
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 lg:px-6 py-2 lg:py-2.5 text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all duration-200 shadow-lg shadow-indigo-500/40 hover:shadow-indigo-500/60 hover:scale-105">
                                        Commencer
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-24 pb-16 sm:pt-32 sm:pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="text-center max-w-4xl mx-auto">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-gray-900 dark:text-white leading-tight mb-6 lg:mb-8">
                        Partagez vos <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 dark:from-indigo-400 dark:via-purple-400 dark:to-pink-400">idées</span> avec le monde.
                    </h1>
                    <p class="text-lg sm:text-xl lg:text-2xl text-gray-600 dark:text-gray-400 leading-relaxed max-w-3xl mx-auto">
                        Une plateforme de blogging simple, fluide et élégante pour les créateurs d'aujourd'hui.
                    </p>
                </div>
            </div>

            <!-- Background Elements -->
            <div class="absolute inset-0 -z-10 overflow-hidden">
                <div class="absolute top-0 left-1/4 w-72 h-72 bg-purple-300/40 dark:bg-purple-600/20 rounded-full blur-3xl"></div>
                <div class="absolute top-20 right-1/4 w-96 h-96 bg-indigo-300/40 dark:bg-indigo-600/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-1/2 w-80 h-80 bg-pink-300/30 dark:bg-pink-600/15 rounded-full blur-3xl"></div>
            </div>
        </div>

        <!-- Latest Articles Grid -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 lg:pb-24">
            <div class="mb-10 lg:mb-14">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1.5 h-10 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">
                        Dernières publications
                    </h2>
                </div>
                <p class="text-gray-600 dark:text-gray-400 ml-6 lg:ml-7">Découvrez les derniers articles de notre communauté</p>
            </div>

            @if($articles && $articles->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($articles as $article)
                        <article class="group flex flex-col bg-white dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-200/60 dark:border-gray-700/60 overflow-hidden h-full hover:-translate-y-2">
                            <div class="p-6 lg:p-7 flex-1 flex flex-col">
                                <!-- Categories & Date -->
                                <div class="flex items-start justify-between mb-4 gap-3">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($article->categories->take(2) as $category)
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-semibold bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-700/50">
                                                #{{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                    <time class="text-xs font-medium text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ $article->created_at->diffForHumans() }}
                                    </time>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white mb-3 lg:mb-4 leading-snug group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">
                                    <a href="{{ route('public.show', [$article->user_id, $article->id]) }}" class="hover:underline decoration-2 underline-offset-4">
                                        {{ $article->title }}
                                    </a>
                                </h3>

                                <!-- Excerpt -->
                                <p class="text-gray-600 dark:text-gray-400 text-sm lg:text-base leading-relaxed mb-6 line-clamp-3 flex-1">
                                    {{ Str::limit($article->content, 160) }}
                                </p>

                                <!-- Author & CTA -->
                                <div class="pt-5 border-t border-gray-200/70 dark:border-gray-700/70 flex items-center justify-between gap-4 mt-auto">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white text-sm font-bold uppercase shadow-md ring-2 ring-white dark:ring-gray-800">
                                            {{ substr($article->user->name, 0, 2) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-black dark:text-white">{{ $article->user->name }}</span>
                                            <span class="text-xs text-gray-600 dark:text-gray-400 font-medium">Auteur</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('public.show', [$article->user_id, $article->id]) }}" class="flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold text-sm transition-colors duration-200 group/link">
                                        Lire
                                        <svg class="w-4 h-4 transition-transform duration-200 group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 lg:py-28 bg-white/60 dark:bg-gray-800/40 backdrop-blur-sm rounded-3xl border-2 border-dashed border-gray-300 dark:border-gray-700">
                    <div class="max-w-md mx-auto px-6">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 flex items-center justify-center">
                            <svg class="w-10 h-10 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">Aucun article publié pour le moment.</p>
                        <p class="text-gray-400 dark:text-gray-500 text-sm mt-2">Soyez le premier à partager vos idées.</p>
                    </div>
                </div>
            @endif
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-2.5">
                        <x-application-logo class="h-8 w-auto text-indigo-600 dark:text-indigo-400 fill-current" />
                        <span class="font-bold text-lg text-gray-900 dark:text-white">BlogLara</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
                        &copy; {{ date('Y') }} BlogLara. Tous droits réservés.
                    </p>
