<x-guest-layout>
    <div class="text-center">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
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
                <span class="inline-flex items-center px-3 py-1 rounded-md text-sm bg-gray-100 text-gray-700">
                    #{{ $category->name }}
                </span>
            @endforeach
        </div>
    @endif

    <!-- Affichage des tags -->
    @if($article->tags->count() > 0)
        <div class="mt-2 flex flex-wrap gap-2">
            @foreach($article->tags as $tag)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
    @endif

    <div>
        <div class="p-6 text-gray-900">
            <p class="text-gray-700">{{ $article->content }}</p>
        </div>
    </div>

    <!-- Liste des commentaires -->
    @foreach ($article->comments as $comment)
        <!-- $comment représente un commentaire -->
        <div class="mt-4 p-4 border border-gray-100 bg-gray-50 rounded-lg shadow-sm">
            <p class="text-gray-700">{{ $comment->content }}</p>
            <p class="text-gray-500 text-xs mt-2">Publié le {{ $comment->created_at->format('d/m/Y') }} par <strong>{{ $comment->user->name }}</strong></p>
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
