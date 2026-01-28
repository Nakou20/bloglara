<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;
use App\Models\Comment;

class PublicController extends Controller
{
    /**
     * Affiche les articles d'un utilisateur spécifique.
     */
    public function index(User $user)
    {
        // On récupère les articles publiés de l'utilisateur
        $articles = Article::where('user_id', $user->id)->where('draft', 0)->get();

        // On retourne la vue avec les articles et l'utilisateur
        return view('public.index', [
            'articles' => $articles,
            'user' => $user
        ]);
    }

    /**
     * Affiche un article spécifique d'un utilisateur.
     */
    public function show(User $user, Article $article)
    {
        // On vérifie que l'article appartient bien à l'utilisateur
        if ($article->user_id !== $user->id) {
            abort(404);
        }

        // On vérifie que l'article est publié (pas un brouillon)
        if ($article->draft) {
             abort(404);
        }

        return view('public.show', [
            'article' => $article,
            'user' => $user
        ]);
    }

    /**
     * Affiche tous les articles publiés avec une option de recherche.
     * Les résultats sont paginés.
     */
    public function all(Request $request)
    {
        // Récupération de la chaîne de recherche depuis l'URL (paramètre 'search')
        $search = $request->query('search');

        // Préparation de la requête de base pour les articles publiés
        // On charge également les relations pour optimiser les performances (Eager Loading)
        $query = Article::with('user', 'categories', 'tags')
            ->where('draft', false)
            ->latest();

        // Si l'utilisateur a saisi un terme de recherche
        if ($search) {
            $query->where(function ($q) use ($search) {
                // On recherche le terme dans le titre ou le contenu de l'article
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Pagination à 9 articles par page
        // withQueryString() permet de garder le paramètre de recherche lors de la navigation entre les pages
        $articles = $query->paginate(9)->withQueryString();

        // Retourne la vue 'public.all' avec les données
        return view('public.all', [
            'articles' => $articles,
            'search' => $search
        ]);
    }
}