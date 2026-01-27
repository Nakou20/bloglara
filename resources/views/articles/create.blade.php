<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            Créer un article
        </h2>
    </x-slot>

    <form method="post" action="{{ route('articles.store') }}" class="py-12">
        @csrf

        {{-- Affiche les erreurs de validation --}}
        @if ($errors->any())
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                <div class="rounded-md bg-red-50 p-4 border border-red-100">
                    <div class="font-medium text-red-800">Il y a des erreurs dans le formulaire :</div>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold text-indigo-600 mb-6 border-b border-gray-100 pb-2">Détails de l'article</h3>

                    <!-- Input de titre de l'article -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Titre de l'article</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Quel est le titre de votre histoire ?" class="w-full rounded-xl border-gray-200 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 transition-colors">
                        @error('title')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <!-- Contenu de l'article -->
                    <div class="mb-8">
                        <label for="content" class="block text-sm font-bold text-gray-700 mb-2">Contenu</label>
                        <textarea rows="15" name="content" id="content" placeholder="Laissez libre cours à votre imagination..." class="w-full rounded-xl border-gray-200 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 py-3 px-4 transition-colors">{{ old('content') }}</textarea>
                        @error('content')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                    </div>

                    <!-- Sélection des catégories -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Catégories</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($categories as $category)
                                <div class="flex items-center group cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="categories[]"
                                        value="{{ $category->id }}"
                                        id="category-{{ $category->id }}"
                                        {{ in_array($category->id, (array) old('categories', [])) ? 'checked' : '' }}
                                        class="rounded-md border-gray-300 bg-white text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5 transition-all group-hover:scale-110"
                                    >
                                    <label for="category-{{ $category->id }}" class="ml-3 text-sm font-medium text-gray-600 group-hover:text-gray-900 cursor-pointer">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sélection des tags existants -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-3">Tags existants</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach($tags as $tag)
                                <div class="flex items-center group cursor-pointer">
                                    <input
                                        type="checkbox"
                                        name="tags[]"
                                        value="{{ $tag->id }}"
                                        id="tag-{{ $tag->id }}"
                                        {{ in_array($tag->id, (array) old('tags', [])) ? 'checked' : '' }}
                                        class="rounded-md border-gray-300 bg-white text-purple-600 shadow-sm focus:ring-purple-500 w-5 h-5 transition-all group-hover:scale-110"
                                    >
                                    <label for="tag-{{ $tag->id }}" class="ml-3 text-sm font-medium text-gray-600 group-hover:text-gray-900 cursor-pointer">
                                        <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-purple-100 text-purple-700 border border-purple-200 transition-colors">
                                            #{{ $tag->name }}
                                        </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Ajout de nouveaux tags par texte -->
                    <div class="mb-10">
                        <label for="new_tags" class="block text-sm font-bold text-gray-700 mb-2">Ajouter de nouveaux tags</label>
                        <input type="text" name="new_tags" id="new_tags" value="{{ old('new_tags') }}" placeholder="Séparez les tags par des virgules (ex: Voyage, Cuisine, Tech)..." class="w-full rounded-xl border-gray-200 bg-white text-gray-900 shadow-sm focus:border-purple-500 focus:ring-purple-500 py-3 transition-colors">
                        @error('new_tags')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                        <p class="text-xs text-gray-400 mt-2 italic flex items-center gap-1">
                            <svg class="w-3 h-3 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                            Les nouveaux tags seront créés automatiquement s'ils n'existent pas.
                        </p>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <!-- Action sur le formulaire -->
                        <div class="flex items-center group cursor-pointer">
                            <input type="checkbox" name="draft" id="draft" {{ old('draft') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5 transition-transform group-hover:scale-110">
                            <label for="draft" class="ml-3 text-sm font-medium text-gray-600 group-hover:text-gray-900 cursor-pointer">Enregistrer comme brouillon</label>
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
