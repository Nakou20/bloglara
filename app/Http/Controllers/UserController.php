<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        // Récupérer toutes les catégories pour les afficher dans le formulaire
        $categories = Category::all();
        
        return view('articles.create', [
            'categories' => $categories
        ]);
    }
    public function store(Request $request)
    {
        // On récupère les données du formulaire
        $data = $request->only(['title', 'content', 'draft']);

        // Créateur de l'article (auteur)
        $data['user_id'] = Auth::user()->id;

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On crée l'article
        $article = Article::create($data); // $Article est l'objet article nouvellement créé

        // Synchronisation des catégories sélectionnées dans le formulaire
        $article->categories()->sync($request->input('categories', []));

        // On redirige l'utilisateur vers la liste des articles
        return redirect()->route('dashboard');
    }

    public function index()
    {
        // On récupère l'utilisateur connecté.
        $user = Auth::user();

        // On récupère uniquement les articles de l'utilisateur connecté.
        $articles = Article::where('user_id', Auth::id())->get();

        return view('dashboard', [
            'articles' => $articles
        ]);
    }
    public function edit(Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }

        // Récupérer toutes les catégories pour les afficher dans le formulaire
        $categories = Category::all();

        // On retourne la vue avec l'article et les catégories
        return view('articles.edit', [
            'article' => $article,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }

        // On récupère les données du formulaire
        $data = $request->only(['title', 'content', 'draft']);

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On met à jour l'article
        $article->update($data);

        // Synchronisation des catégories sélectionnées dans le formulaire
        $article->categories()->sync($request->input('categories', []));

        // On redirige l'utilisateur vers la liste des articles (avec un flash)
        return redirect()->route('dashboard')->with('success', 'Article mis à jour !');
    }

    public function remove(Article $article) {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }
        return view('articles.remove', ['article' => $article]);
    }

    public function destroy(Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::user()->id) {
            abort(403);
        }

        // On supprime l'article
        $article->delete();

        // On redirige l'utilisateur vers la liste des articles (avec un flash)
        return redirect()->route('dashboard')->with('success', 'Article supprimé !');
    }

    // Page publique d'accueil listant les articles non-brouillon
    public function publicIndex()
    {
        $articles = Article::where('draft', 0)->latest()->get();
        return view('welcome', ['articles' => $articles]);
    }

    // Page show pour afficher un article complet
    public function show(Article $article)
    {
        // Si l'article est en draft, seul l'auteur peut le voir
        if ($article->draft && (!Auth::check() || Auth::id() !== $article->user_id)) {
            abort(404);
        }

        return view('articles.show', ['article' => $article]);
    }
}
