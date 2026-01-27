<x-guest-layout>
    <div class="text-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $article->title }}
        </h2>
    </div>

    <div class="text-gray-500 text-sm">
        Publié le {{ $article->created_at->format('d/m/Y') }} par <a href="{{ route('public.index', $article->user->id) }}">{{ $article->user->name }}</a>
    </div>

    <!-- Affichage des catégories -->
    @if($article->categories->count() > 0)
        <div class="mt-3 flex flex-wrap gap-2">
            @foreach($article->categories as $category)
                <span class="inline-flex items-center px-3 py-1 rounded-md text-sm bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    #{{ $category->name }}
                </span>
            @endforeach
        </div>
    @endif

    <div>
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="text-gray-700 dark:text-gray-300">{{ $article->content }}</p>
        </div>
    </div>

    <!-- Liste des commentaires -->
    @foreach ($article->comments as $comment)
        <!-- $comment représente un commentaire -->
        <div class="mt-4 p-4 border rounded">
            <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
            <p class="text-gray-500 text-sm">Publié le {{ $comment->created_at->format('d/m/Y') }} par {{ $comment->user->name }}</p>
        </div>
    @endforeach

    @auth
    <!-- Le code affiché si la personne est connecté -->
        <!-- Ajout d'un commentaire -->
        <form action="{{ route('comments.store') }}" method="post" class="mt-6">
            @csrf
            <input type="hidden" name="articleId" value="{{ $article->id }}">
            <textarea name="content" placeholder="Votre commentaire..." class="w-full p-2 border rounded"></textarea>
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">Commenter</button>
        </form>
    @endauth

    @auth
        <a href="{{ route('article.like', $article->id) }}" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
            <img src="/TortueGeniale.svg" alt="" class="h-12 w-6 text-white">
            <span>{{$article->likes}}</span>
        </a>
    @endauth
</x-guest-layout>
