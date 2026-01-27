<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;

class PublicController extends Controller
{
    public function index(User $user)
    {
        // On récupère les articles publiés de l'utilisateur
        $articles = Article::where('user_id', $user->id)->where('draft', 0)->get();

        // On retourne la vue
        return view('public.index', [
            'articles' => $articles,
            'user' => $user
        ]);
    }
    public function show(User $user, Article $article)
    {
        // On vérifie que l'article appartient bien à l'utilisateur
        if ($article->user_id !== $user->id) {
            abort(404);
        }

        // On vérifie que l'article est publié (draft == 0)
        if ($article->draft) {
             abort(404);
        }

        // Récupération des articles similaires (basés sur les tags ou catégories)
        $tagIds = $article->tags->pluck('id');
        $categoryIds = $article->categories->pluck('id');

        $similarArticles = Article::where('id', '!=', $article->id)
            ->where('draft', 0)
            ->where(function ($query) use ($tagIds, $categoryIds) {
                $query->whereHas('tags', function ($q) use ($tagIds) {
                    $q->whereIn('tags.id', $tagIds);
                })->orWhereHas('categories', function ($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            })
            ->with(['user', 'categories', 'tags'])
            ->latest()
            ->take(3)
            ->get();

        return view('public.show', [
            'article' => $article,
            'user' => $user,
            'similarArticles' => $similarArticles
        ]);
    }
}