<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    <!-- Articles -->
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @foreach ($articles as $article)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition hover:shadow-md">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h2 class="text-2xl font-bold mb-2 text-indigo-600 dark:text-indigo-400">{{ $article->title }}</h2>
                        <p class="text-gray-700 dark:text-gray-300">{{ substr($article->content, 0, 150) }}...</p>
                        <div class="mt-4 flex justify-end">
                            <a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-500 dark:hover:text-indigo-300">Lire plus &rarr;</a>
                        </div>
                        <!-- Link to edit article -->
                        @if ($article->user_id === Auth::id())
                        <div class="text-right">
                            <a href="{{ route('articles.edit', $article->id) }}" class="text-red-500 hover:text-red-700">Modifier</a>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Message flash -->
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mt-6 mb-6 text-center">
            {{ session('success') }}
        </div>
    @endif

</x-app-layout>
