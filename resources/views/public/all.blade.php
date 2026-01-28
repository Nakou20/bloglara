<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Hero Section de la page avec Barre de recherche -->
            <div class="text-center mb-16">
                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
                    Tous nos <span class="text-indigo-600">Articles</span>
                </h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
                    Explorez l'intégralité des publications de notre communauté d'auteurs.
                </p>

                <!-- Formulaire de recherche -->
                <div class="max-w-xl mx-auto">
                    <form action="{{ route('articles.all') }}" method="GET" class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}" 
                            placeholder="Rechercher par tag ou catégorie..." 
                            class="block w-full pl-11 pr-24 py-4 bg-white border-2 border-gray-100 rounded-2xl shadow-sm focus:border-indigo-500 focus:ring-0 text-gray-900 placeholder-gray-400 transition-all duration-300"
                        >
                        <div class="absolute inset-y-2 right-2 flex">
                            <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-lg transition-all duration-200">
                                Rechercher
                            </button>
                        </div>
                    </form>
                    
                    @if($search)
                        <div class="mt-4 flex justify-center items-center gap-2">
                            <span class="text-sm text-gray-500">Résultats pour : <strong>"{{ $search }}"</strong></span>
                            <a href="{{ route('articles.all') }}" class="text-xs font-bold text-red-500 hover:text-red-600 underline underline-offset-4">
                                Effacer la recherche
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Grille d'articles -->
            @if($articles->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                    @foreach($articles as $index => $article)
                        <x-article-card :article="$article" :index="$index" />
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @else
                <!-- État vide si aucun article ne correspond -->
                <div class="text-center py-20 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-indigo-100 flex items-center justify-center">
                        <svg class="w-10 h-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <p class="text-gray-600 text-lg font-medium">Aucun article trouvé.</p>
                    <p class="text-gray-400 text-sm mt-2">Essayez d'autres mots-clés ou parcourez tous les articles.</p>
                    <a href="{{ route('articles.all') }}" class="mt-6 inline-block text-indigo-600 font-bold hover:text-indigo-700 transition-colors">
                        Voir tous les articles
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
