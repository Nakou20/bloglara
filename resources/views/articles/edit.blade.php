<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Modifier l'article {{ $article->title }}
        </h2>
    </x-slot>

    <form method="post" action="{{ route('articles.update', $article->id) }}" class="py-12">
        @csrf
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Détails de l'article</h3>
                    
                    <!-- Input de titre de l'article -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Titre</label>
                        <input type="text" name="title" id="title" value="{{ $article->title }}" placeholder="Entrez le titre..." class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Contenu de l'article -->
                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contenu</label>
                        <textarea rows="15" name="content" id="content" placeholder="Rédigez votre article ici..." class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $article->content }}</textarea>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <!-- Action sur le formulaire -->
                        <div class="flex items-center">
                            <input type="checkbox" name="draft" id="draft" {{ $article->draft ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="draft" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Enregistrer comme brouillon</label>
                        </div>
                        <div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow transition duration-150 ease-in-out">
                                Modifier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
