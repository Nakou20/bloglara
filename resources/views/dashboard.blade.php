<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Votre Dashboard') }}
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($articles as $article)
                    <x-article-card :article="$article" :showAuthor="false">
                        @if ($article->user_id === Auth::id())
                            <x-slot name="actions">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('articles.edit', $article->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-blue-700 rounded-lg font-bold text-[11px] text-white uppercase tracking-widest hover:bg-blue-700 transition duration-150 shadow-sm">
                                        Modifier
                                    </a>
                                    <a href="{{ route('articles.remove', $article->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-red-700 rounded-lg font-bold text-[11px] text-white uppercase tracking-widest hover:bg-red-700 transition duration-150 shadow-sm">
                                        Supprimer
                                    </a>
                                </div>
                            </x-slot>
                        @endif
                    </x-article-card>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
