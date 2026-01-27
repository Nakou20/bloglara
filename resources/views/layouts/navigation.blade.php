<!-- Barre de navigation avec fond blanc pur et flou léger -->
<nav x-data="{ open: false }" class="bg-white/95 backdrop-blur-lg border-b border-gray-100 shadow-sm sticky top-0 z-50 transition-colors duration-300">
    <!-- Menu de navigation principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 lg:h-20">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2.5 group">
                        <x-application-logo class="block h-9 w-auto fill-current text-indigo-600 transition-transform duration-300 ease-out group-hover:scale-110 group-hover:rotate-3" />
                        <span class="font-bold text-lg text-gray-900 tracking-tight hidden sm:block">Tortue Blog</span>
                    </a>
                </div>

                <!-- Liens de navigation -->
                <div class="hidden space-x-1 lg:space-x-2 sm:flex">
                    @auth
                        <x-link variant="nav" :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 hover:bg-gray-100">
                            {{ __('Espace Auteur') }}
                        </x-link>

                        <x-link variant="nav" :href="route('public.index', Auth::id())" :active="request()->routeIs('public.index')" class="px-4 py-2 rounded-lg text-sm font-semibold transition-all duration-200 hover:bg-gray-100">
                            {{ __('Mon Blog Public') }}
                        </x-link>

                        <x-link variant="nav" :href="route('articles.create')" :active="request()->routeIs('articles.create')" class="px-4 py-2 rounded-lg text-sm font-bold bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 transition-all duration-200 hover:scale-105">
                                {{ __('Nouvel Article') }}
                        </x-link>
                    @endauth
                </div>
            </div>

            <!-- Paramètres et Profil (Menu déroulant) -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @auth
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
                                        {{ __('Log Out') }}
                                    </x-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-100 transition-all duration-200">
                            {{ __('Log in') }}
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg text-sm font-semibold bg-gray-900 text-white hover:bg-gray-800 transition-all duration-200">
                                {{ __('Register') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Menu Hamburger (Mobile) -->
            <div class="flex items-center sm:hidden gap-2">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2.5 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu de navigation réactif (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100 bg-white">
        <div class="pt-3 pb-3 space-y-1 px-4">
            @auth
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-semibold transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    {{ __('Espace Auteur') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('public.index', Auth::id())" :active="request()->routeIs('public.index')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-semibold transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    {{ __('Mon Blog Public') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('articles.create')" :active="request()->routeIs('articles.create')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-bold bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    {{ __('Nouvel Article') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Options de réglages réactives (Mobile) -->
        <div class="pt-4 pb-3 border-t border-gray-100">
            @auth
                <div class="px-4 mb-3">
                    <div class="flex items-center gap-3">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}" class="h-12 w-12 rounded-full object-cover border mb-0" />
                        @else
                            <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center text-white text-sm font-bold uppercase shadow-lg">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                        @endif

                        <div>
                            <div class="font-bold text-base text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="space-y-1 px-4">
                    <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-semibold transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Déconnexion -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-semibold text-red-600 hover:bg-red-50 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1 px-4">
                    <x-responsive-nav-link :href="route('login')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-semibold transition-all duration-200">
                        {{ __('Log in') }}
                    </x-responsive-nav-link>
                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="route('register')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-base font-semibold transition-all duration-200">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif
                </div>
            @endauth
        </div>
    </div>
</nav>
