
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Supprimer l\'article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Êtes-vous sûr de vouloir supprimer cet article ?</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ $article->title }}
                    </p>

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 bg-gray-200 hover:bg-gray-300 rounded px-4 py-2 mr-2">
                            Annuler
                        </a>
                        <form method="POST" action="{{ route('articles.destroy', $article->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white rounded px-4 py-2">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
