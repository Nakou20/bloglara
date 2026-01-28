<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // On récupère le tag de recherche s'il existe dans l'URL
    $selectedTag = request()->query('tag');

    // Construction de la requête pour les articles
    $query = \App\Models\Article::with('user', 'categories', 'tags', 'likers')
        ->where('draft', false)
        ->orderBy('likes', 'desc')
        ->latest();

    // Si un tag est spécifié, on filtre les articles
    if ($selectedTag) {
        $query->whereHas('tags', function ($q) use ($selectedTag) {
            $q->where('name', $selectedTag);
        });
    }

    $articles = $query->take(6)->get();

    // On récupère tous les tags pour les afficher comme filtres sur la page d'accueil
    $allTags = \App\Models\Tag::has('articles')->get();

    return view('welcome', compact('articles', 'allTags', 'selectedTag'));
});

// Route pour afficher tous les articles avec recherche
Route::get('/articles', [PublicController::class, 'all'])->name('articles.all');

Route::post('/articles/store', [UserController::class, 'store'])->name('articles.store');
Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
Route::post('/comments/store', [CommentController::class, 'store'])->name('comments.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/articles/create', [UserController::class, 'create'])->name('articles.create');
    Route::get('/articles/{article}/edit', [UserController::class, 'edit'])->name('articles.edit');
    Route::post('/articles/{article}/update', [UserController::class, 'update'])->name('articles.update');
    Route::get('/articles/{article}/remove', [UserController::class, 'remove'])->name('articles.remove');
    Route::delete('/articles/{article}/destroy', [UserController::class, 'destroy'])->name('articles.destroy');
    Route::get('/articles/{article}/like', [ArticleController::class, 'like'])->name('article.like');
});

require __DIR__.'/auth.php';

Route::get('/{user}', [PublicController::class, 'index'])->name('public.index');
Route::get('/{user}/{article}', [PublicController::class, 'show'])->name('public.show');
