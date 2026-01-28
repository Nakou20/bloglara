<!-- Barre de navigation avec fond blanc pur et flou léger -->
<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-lg border-b border-gray-100 shadow-sm sticky top-0 z-50 transition-colors duration-300">
    <!-- Menu de navigation principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 lg:h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600 transition-transform duration-300 ease-out group-hover:scale-110 group-hover:rotate-3" />
                        <span class="font-bold text-lg text-gray-900 tracking-tight hidden sm:block">Tortue Blog</span>
                    </a>
                </div>

                <!-- Liens de navigation (Gauche - Optionnel) -->
                <div class="hidden space-x-1 lg:space-x-2 sm:flex ml-4">
                    @auth
                        <!-- Vous pouvez ajouter d'autres liens ici si nécessaire -->
                    @endauth
                </div>
            </div>

            <!-- Centre de la barre de navigation : Bouton principal -->
            <div class="hidden sm:flex items-center justify-center flex-1">
                <a href="{{ route('articles.all') }}" class="px-6 py-2 rounded-full text-sm font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 shadow-sm hover:bg-indigo-100 transition-all duration-200 {{ request()->routeIs('articles.all') ? 'bg-indigo-100 ring-2 ring-indigo-500/20' : '' }}">
                    {{ __('Tous les articles') }}
                </a>
            </div>

            <!-- Paramètres et Profil (Menu déroulant - Droite) -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @auth
                    <!-- Liens spécifiques à l'auteur (Mon Blog, Nouvel Article) placés à droite -->
                    <div class="hidden lg:flex items-center gap-2 mr-2">
                        <x-link variant="nav" :href="route('public.index', Auth::id())" :active="request()->routeIs('public.index')" class="px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-100">
                            {{ __('Mon Blog') }}
                        </x-link>
                        <x-link variant="nav" :href="route('articles.create')" :active="request()->routeIs('articles.create')" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-indigo-600 text-white hover:bg-indigo-700 shadow-md">
                            {{ __('Nouveau') }}
                        </x-link>
                    </div>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 text-sm font-semibold rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover border" />
                                @else
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white text-xs font-bold uppercase shadow-md">
                                        {{ substr(Auth::user()->name, 0, 2) }}
                                    </div>
                                @endif

                                <div class="hidden lg:block">{{ Auth::user()->name }}</div>
                                <svg class="fill-current h-4 w-4 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="py-1">
                                <x-link variant="dropdown" :href="route('profile.edit')" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Profile') }}
                                </x-link>

                                <div class="border-t border-gray-100 my-1"></div>

                                <!-- Déconnexion -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-link variant="dropdown" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors duration-150">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Déconnexion') }}
                                    </x-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-all duration-200">
                            {{ __('Connexion') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-sm font-semibold bg-gray-900 text-white hover:bg-gray-800 transition-all duration-200">
                                {{ __('Inscription') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </div> 
</nav>
