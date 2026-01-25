<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('articles.create');
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

        // Exemple pour ajouter la catégorie 1 à l'article
        // $article->categories()->sync(1);

        // Exemple pour ajouter des catégories à l'article
        // $article->categories()->sync([1, 2, 3]);

        // Exemple pour ajouter des catégories à l'article en venant du formulaire
        // $article->categories()->sync($request->input('categories'));

        // On redirige l'utilisateur vers la liste des articles
        return redirect()->route('dashboard');
    }

    public function index()
    {
        // On récupère l'utilisateur connecté.
        $user = Auth::user();

        // On récupère tous les articles.
        $articles = Article::all();

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

        // On retourne la vue avec l'article
        return view('articles.edit', [
            'article' => $article
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
