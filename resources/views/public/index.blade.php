<x-public-layout>
    <div class="mb-8">
        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Liste des articles publiés de {{ $user->name }}
        </h2>
    </div>

    <div class="space-y-12">
        <!-- Articles -->
        @foreach ($articles as $article)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $article->title }}</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ substr($article->content, 0, 100) }}...</p>
                
                <a href="{{ route('public.show', [$article->user_id, $article->id]) }}" class="text-red-500 hover:text-red-700 font-medium text-sm">
                    Lire la suite
                </a>
            </div>
        </div>
        @endforeach
    </div>
</x-public-layout>