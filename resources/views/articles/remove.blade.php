<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Supprimer l\'article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-2">Supprimer définitivement ?</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Êtes-vous sûr de vouloir supprimer l'article <span class="font-bold text-indigo-600">"{{ $article->title }}"</span> ? Cette action est irréversible.
                    </p>

                    <div class="flex items-center justify-center gap-4">
                        <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all">
                            Annuler
                        </a>
                        <form method="POST" action="{{ route('articles.destroy', $article->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 transition-all hover:scale-105">
                                Supprimer l'article
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
