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

        <!-- Pas de script de thème : dark mode désactivé -->
    </head>

    <!-- Force le fond en blanc et le texte en gris très sombre pour une lisibilité maximale -->
    <body class="antialiased font-sans bg-white text-gray-900 min-h-screen">
        <!-- Header Navigation -->
        <!-- Barres de navigation avec fond blanc (semi-transparent) et bordure claire -->
        <nav class="fixed top-0 w-full bg-white/95 backdrop-blur-lg border-b border-gray-100 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    <!-- Left side - Logo -->
                    <div class="flex items-center">
                        <a href="/" class="flex items-center gap-2.5 group">
                            <x-application-logo class="h-9 w-auto text-indigo-600 fill-current transition-transform duration-300 ease-out group-hover:scale-110" />
                            <span class="font-bold text-lg lg:text-xl text-gray-900 tracking-tight">Tortue Blog</span>
                        </a>
                    </div>

                    <!-- Center - Main Navigation -->
                    <div class="hidden sm:flex items-center justify-center flex-1">
                        <a href="{{ route('articles.all') }}" class="px-6 py-2 rounded-full text-sm font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 shadow-sm hover:bg-indigo-100 transition-all duration-200">
                            Tous les articles
                        </a>
                    </div>

                    <!-- Right side - Actions -->
                    <div class="flex items-center gap-3 lg:gap-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-gray-100">
                                    Espace Auteur
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition-colors duration-200 px-3 py-2 rounded-lg hover:bg-gray-100">
                                    Connexion
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 lg:px-6 py-2 lg:py-2.5 text-sm font-bold bg-gray-900 text-white rounded-xl transition-all duration-200 shadow-lg hover:bg-gray-800 hover:scale-105">
                                        Inscription
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-24 pb-8 sm:pt-32 sm:pb-12 lg:pt-40 lg:pb-16 overflow-hidden">
            <!-- Éléments de fond colorés (plus doux pour le thème clair) -->
            <div class="absolute inset-0 -z-10 overflow-hidden">
                <div class="absolute top-0 left-1/4 w-72 h-72 bg-purple-100/50 rounded-full blur-3xl"></div>
                <div class="absolute top-20 right-1/4 w-96 h-96 bg-indigo-100/50 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-1/2 w-80 h-80 bg-pink-100/40 rounded-full blur-3xl"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl sm:text-6xl font-extrabold text-gray-900 tracking-tight mb-6">
                    Découvrez des <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">histoires</span> passionnantes
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-gray-600 mb-10">
                    Explorez les dernières actualités, tutoriels et réflexions de notre communauté d'auteurs passionnés.
                </p>

                <!-- Barre de recherche de Tags -->
                <div class="max-w-2xl mx-auto mt-8">
                    <form action="/" method="GET" class="relative group">
                        <!-- Icône de recherche -->
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <!-- Input de recherche avec fond blanc et bordure douce -->
                        <input
                            type="text"
                            name="tag"
                            value="{{ $selectedTag }}"
                            placeholder="Rechercher par tag (ex: Laravel, PHP...)"
                            class="block w-full pl-11 pr-24 py-4 bg-white border-2 border-gray-100 rounded-2xl shadow-xl focus:border-indigo-500 focus:ring-0 text-gray-900 placeholder-gray-400 transition-all duration-300"
                        >

                        <!-- Bouton de recherche -->
                        <div class="absolute inset-y-2 right-2 flex">
                            <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg transition-all duration-200">
                                Rechercher
                            </button>
                        </div>
                    </form>

                    <!-- Suggestions de tags cliquables -->
                    @if($allTags->count() > 0)
                        <div class="flex flex-wrap justify-center gap-2 mt-4">
                            <span class="text-xs font-medium text-gray-500 self-center mr-1">Tags populaires :</span>
                            @foreach($allTags->take(8) as $tag)
                                <a href="/?tag={{ $tag->name }}" class="px-3 py-1 rounded-full text-xs font-semibold transition-all duration-200 {{ $selectedTag == $tag->name ? 'bg-purple-600 text-white shadow-md' : 'bg-purple-50 text-purple-600 hover:bg-purple-100 border border-purple-100' }}">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach

                            @if($selectedTag)
                                <a href="/" class="ml-2 text-xs font-bold text-red-500 hover:text-red-600 transition-colors underline underline-offset-4">
                                    Effacer le filtre
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Featured Popular Articles Grid -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 lg:pb-24">
            <div class="mb-10 lg:mb-14">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-1.5 h-10 bg-gradient-to-b from-indigo-600 to-purple-600 rounded-full"></div>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900">
                        @if($selectedTag)
                            Articles marqués #{{ $selectedTag }}
                        @else
                            Dernières publications
                        @endif
                    </h2>
                    </div>
                <p class="text-gray-600 ml-6 lg:ml-7">
                    @if($selectedTag)
                        Affichage des articles liés au tag "{{ $selectedTag }}"
                    @else
                        Découvrez les derniers articles de notre communauté
                    @endif
                </p>
            </div>

            @if($articles && $articles->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                    @foreach($articles as $index => $article)
                        <x-article-card :article="$article" :index="$index" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 lg:py-28 bg-white/60 backdrop-blur-sm rounded-3xl border-2 border-dashed border-gray-200">
                    <div class="max-w-md mx-auto px-6">
                        <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                            <svg class="w-10 h-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <p class="text-gray-600 text-lg font-medium">Aucun article publié pour le moment.</p>
                        <p class="text-gray-400 text-sm mt-2">Soyez le premier à partager vos idées.</p>
                    </div>
                </div>
            @endif
        </main>
