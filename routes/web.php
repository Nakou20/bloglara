<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $articles = \App\Models\Article::with('user', 'categories')->latest()->take(6)->get();
    return view('welcome', compact('articles'));
});

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
});

require __DIR__.'/auth.php';

Route::get('/{user}', [PublicController::class, 'index'])->name('public.index');
Route::get('/{user}/{article}', [PublicController::class, 'show'])->name('public.show');
