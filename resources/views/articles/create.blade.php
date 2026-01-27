<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            Créer un article
        </h2>
    </x-slot>

    <form method="post" action="{{ route('articles.store') }}" class="py-12">
        @csrf
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold text-indigo-600 dark:text-indigo-400 mb-6 border-b border-gray-100 dark:border-gray-700 pb-2">Détails de l'article</h3>

                    <!-- Input de titre de l'article -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Titre de l'article</label>
                        <input type="text" name="title" id="title" placeholder="Quel est le titre de votre histoire ?" class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 transition-colors">
                    </div>

                    <!-- Contenu de l'article -->
                    <div class="mb-8">
                        <label for="content" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Contenu</label>
                        <textarea rows="15" name="content" id="content" placeholder="Laissez libre cours à votre imagination..." class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 transition-colors"></textarea>
                    </div>

                    <!-- Sélection des catégories -->
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">Catégories</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($categories as $category)
                                <div class="flex items-center group cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="categories[]"
                                        value="{{ $category->id }}"
                                        id="category-{{ $category->id }}"
                                        class="rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5 transition-all group-hover:scale-110"
                                    >
                                    <label for="category-{{ $category->id }}" class="ml-3 text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 cursor-pointer">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sélection des tags existants -->
                    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-3">Tags existants</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach($tags as $tag)
                                <div class="flex items-center group cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="tags[]"
                                        value="{{ $tag->id }}"
                                        id="tag-{{ $tag->id }}"
                                        class="rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-purple-600 shadow-sm focus:ring-purple-500 w-5 h-5 transition-all group-hover:scale-110"
                                    >
                                    <label for="tag-{{ $tag->id }}" class="ml-3 text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 cursor-pointer">
                                        <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800 transition-colors">
                                            #{{ $tag->name }}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Ajout de nouveaux tags par texte -->
                    <div class="mb-10">
                        <label for="new_tags" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">Ajouter de nouveaux tags</label>
                        <input type="text" name="new_tags" id="new_tags" placeholder="Séparez les tags par des virgules (ex: Voyage, Cuisine, Tech)..." class="w-full rounded-xl border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 transition-colors">
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 italic flex items-center gap-1">
                            <svg class="w-3 h-3 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            Les nouveaux tags seront créés automatiquement s'ils n'existent pas.
                        </p>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <!-- Action sur le formulaire -->
                        <div class="flex items-center group cursor-pointer">
                            <input type="checkbox" name="draft" id="draft" class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5 transition-transform group-hover:scale-110">
                            <label for="draft" class="ml-3 text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-200 cursor-pointer">Enregistrer comme brouillon</label>
                        </div>
                        <div>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-md shadow transition duration-150 ease-in-out hover:scale-105">
                                Publier
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
