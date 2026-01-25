<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Message flash -->
    @if (session('success'))
        <div class="py-12 pb-0">
             <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="mx-auto w-fit bg-green-600 text-white px-8 py-4 rounded-lg shadow-lg font-bold border border-green-700">
                    {{ session('success') }}
                </div>
            </div>
        </div>
    @endif    

    <!-- Articles -->
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($articles as $article)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition hover:shadow-md mb-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-2xl font-bold mb-2 text-indigo-600 dark:text-indigo-400">{{ $article->title }}</h2>
                        <p class="text-gray-700 dark:text-gray-300">{{ substr($article->content, 0, 150) }}...</p>
                        <div class="mt-4 flex justify-end">
                            <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-300">Lire plus &rarr;</a>
                        </div>
                        <!-- Link to edit article -->
                        <!-- Actions buttons -->
                        @if ($article->user_id === Auth::id())
                            <div class="mt-4 flex justify-end space-x-3">
                                <a href="{{ route('articles.edit', $article->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Modifier
                                </a>
                                <a href="{{ route('articles.remove', $article->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Supprimer
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
