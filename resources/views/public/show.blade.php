<x-public-layout>
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-8">
            <h1 class="font-bold text-4xl text-gray-900 leading-tight mb-2">
                {{ $article->title }}
            </h1>
            <div class="text-gray-500 text-base">
                Publié le {{ $article->created_at->format('d/m/Y') }} par <a href="{{ route('public.index', $article->user->id) }}" class="text-blue-600 hover:underline">{{ $article->user->name }}</a>
            </div>
        </div>

        <!-- Affichage des catégories -->
        @if($article->categories->count() > 0)
            <div class="flex justify-center flex-wrap gap-2 mb-6">
                @foreach($article->categories as $category)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700 font-medium">
                        #{{ $category->name }}
                    </span>
                @endforeach
            </div>
        @endif

        <!-- Affichage des tags -->
        @if($article->tags->count() > 0)
            <div class="flex justify-center flex-wrap gap-2 mb-8">
                @foreach($article->tags as $tag)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif

        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 mb-10">
            <div class="prose max-w-none text-gray-800 text-lg leading-relaxed">
                {!! nl2br(e($article->content)) !!}
            </div>
        </div>

        @auth
            <div class="flex justify-center mb-12">
                <a href="{{ route('article.like', $article->id) }}" class="flex flex-col items-center justify-center w-24 h-28 rounded-3xl bg-gradient-to-br from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white transition-all duration-300 shadow-lg hover:shadow-2xl hover:scale-110 group/like border-4 border-white">
                    <img src="/TortueGeniale.svg" alt="Like" class="w-16 h-16 mb-2 group-hover/like:rotate-12 transition-transform duration-300">
                    <span class="text-lg font-black">{{ $article->likes ?? 0 }}</span>
                </a>
            </div>
        @endauth

        <!-- Liste des commentaires -->
        <div class="mt-8 max-w-3xl mx-auto">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Commentaires</h3>
            
            @foreach ($article->comments as $comment)
                <div class="mb-4 p-6 border border-gray-100 bg-white rounded-lg shadow-sm">
                    <p class="text-gray-800 mb-2">{{ $comment->content }}</p>
                    <p class="text-gray-500 text-xs">
                        Publié le {{ $comment->created_at->format('d/m/Y') }} par <span class="font-semibold text-gray-700">{{ $comment->user->name }}</span>
                    </p>
                </div>
            @endforeach

            @auth
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Ajouter un commentaire</h4>
                    <form action="{{ route('comments.store') }}" method="post" class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        @csrf
                        <input type="hidden" name="articleId" value="{{ $article->id }}">
                        <textarea name="content" rows="4" placeholder="Votre commentaire..." class="w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                        <div class="flex justify-end mt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition">Publier</button>
                        </div>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</x-public-layout>
