<x-public-layout>
    <div class="mb-8"> 
        <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Liste des articles publiés de {{ $user->name }}
        </h2>
    </div>

    <div class="grid grid-cols-3 gap-8">
        <!-- Articles -->
        @foreach ($articles as $article)
            <x-article-card :article="$article" :showAuthor="false" />
        @endforeach
    </div>
</x-public-layout>
