<x-guest-layout>
    <div class="max-w-4xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight mb-4">
                {{ $article->title }}
            </h2>
            <div class="flex items-center justify-center gap-2 text-gray-500 dark:text-gray-400 text-sm">
                <span>Publié le {{ $article->created_at->format('d/m/Y') }}</span>
                <span>•</span>
                <a href="{{ route('public.index', $article->user->id) }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                    {{ $article->user->name }}
                </a>
            </div>

            <!-- Affichage des catégories & Tags -->
            <div class="mt-6 flex flex-wrap justify-center gap-2">
                @foreach($article->categories as $category)
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800">
                        #{{ $category->name }}
                    </span>
                @endforeach
                @foreach($article->tags as $tag)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 border border-purple-100 dark:border-purple-800">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl dark:shadow-none border border-gray-100 dark:border-gray-700 overflow-hidden mb-12">
            <div class="p-8 sm:p-10 text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                <p class="whitespace-pre-line">{{ $article->content }}</p>
            </div>

            <!-- Like Button -->
            @auth
                <div class="pb-10 flex justify-center">
                    <a href="{{ route('article.like', $article->id) }}" class="flex flex-col items-center justify-center w-24 h-28 rounded-3xl bg-gradient-to-br from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white transition-all duration-300 shadow-lg hover:shadow-2xl hover:scale-110 group/like border-4 border-white dark:border-gray-700">
                        <img src="/TortueGeniale.svg" alt="Like" class="w-16 h-16 mb-2 group-hover/like:rotate-12 transition-transform duration-300">
                        <span class="text-lg font-black">{{ $article->likes ?? 0 }}</span>
                    </a>
                </div>
            @endauth
        </div>

        <!-- Section Commentaires -->
        <div class="mb-16">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                Commentaires ({{ $article->comments->count() }})
            </h3>

            @auth
                <form action="{{ route('comments.store') }}" method="post" class="mb-8 p-6 bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-100 dark:border-gray-700">
                    @csrf
                    <input type="hidden" name="articleId" value="{{ $article->id }}">
                    <textarea name="content" rows="3" placeholder="Partagez votre avis..." class="w-full p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:text-white transition-all" required></textarea>
                    <div class="mt-3 flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all hover:scale-105">
                            Commenter
                        </button>
                    </div>
                </form>
            @endauth

            <div class="space-y-4">
                @forelse ($article->comments as $comment)
                    <div class="p-5 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm">
                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                        <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
                            <span class="font-bold text-gray-900 dark:text-gray-100">{{ $comment->user->name }}</span>
                            <span>•</span>
                            <span>{{ $comment->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-center py-10 text-gray-500 italic">Soyez le premier à commenter cet article !</p>
                @endforelse
            </div>
        </div>

        <!-- Articles Similaires -->
        @if($similarArticles && $similarArticles->count() > 0)
            <div class="border-t border-gray-100 dark:border-gray-800 pt-12">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Vous aimerez aussi...</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($similarArticles as $index => $similar)
                        <x-article-card :article="$similar" :index="$index" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-guest-layout>
