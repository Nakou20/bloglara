@props(['article', 'index' => null, 'showAuthor' => true])
<!-- Carte d'article avec fond blanc pur et bordure légère -->
<article {{ $attributes->merge(['class' => 'group relative bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 lg:p-8 border border-gray-100 hover:-translate-y-1']) }}>
    
    <div class="flex items-start gap-6">
        <!-- Contenu principal -->
        <div class="flex-1 min-w-0">
            <!-- Titre de l'article en noir intense -->
            <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3 leading-tight group-hover:text-indigo-600 transition-colors duration-200">
                <a href="{{ route('public.show', [$article->user_id, $article->id]) }}" class="hover:underline decoration-2 underline-offset-4">
                    {{ $article->title }}
                </a>
            </h3>

            <!-- Informations meta (date et auteur) en gris moyen -->
            @if($showAuthor)
                <div class="flex items-center gap-3 text-sm text-gray-500 mb-4">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-medium">{{ $article->created_at->format('d/m/Y') }}</span>
                    </div>
                    <span class="text-gray-300">•</span>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="font-medium">{{ $article->user->name }}</span>
                    </div>
                </div>
            @endif

            <!-- Extrait du contenu en gris sombre pour la lecture -->
            <p class="text-gray-600 text-base lg:text-lg leading-relaxed mb-5 line-clamp-2">
                {{ Str::limit($article->content, 180) }}
            </p>

            <!-- Catégories & Tags avec des couleurs de contraste douces -->
            @if($article->categories->isNotEmpty() || $article->tags->isNotEmpty())
                <div class="flex flex-wrap gap-2 mt-4">
                    <!-- Catégories en dégradé indigo/violet léger -->
                    @foreach($article->categories->take(3) as $category)
                        <span class="inline-flex items-center text-xs px-3 py-1.5 rounded-full bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 font-semibold border border-indigo-100">
                            #{{ $category->name }}
                        </span>
                    @endforeach

                    <!-- Tags en violet clair -->
                    @foreach($article->tags->take(5) as $tag)
                        <span class="inline-flex items-center text-xs px-3 py-1.5 rounded-full bg-purple-50 text-purple-600 font-medium border border-purple-100">
                            {{ $tag->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            <!-- Emplacement pour les actions supplémentaires -->
            @if(isset($actions))
                <div class="mt-6 pt-6 border-t border-gray-100">
                    {{ $actions }}
                </div>
            @endif
        </div>

        <!-- Bouton de Like avec dégradé vif pour la visibilité -->
        <div class="flex-shrink-0">
            <a href="{{ route('article.like', $article->id) }}" class="flex flex-col items-center justify-center w-20 h-24 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white transition-all duration-300 shadow-md hover:shadow-xl hover:scale-105 group/like border-2 border-amber-200/50">
                <img src="/TortueGeniale.svg" alt="Like" class="w-12 h-12 mb-2 group-hover/like:rotate-12 transition-transform duration-300 drop-shadow-sm">
                <span class="text-sm font-black">{{ $article->likes ?? 0 }}</span>
            </a>
        </div>
    </div>

    <!-- Badge de popularité avec fond ambre clair -->
    @if($index !== null && $index < 3)
        <div class="absolute top-4 left-0">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-r-full text-xs font-bold bg-amber-100 text-amber-700 border-y border-r border-amber-200">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                #{{ $index + 1 }}
            </span>
        </div>
    @endif

</article>
