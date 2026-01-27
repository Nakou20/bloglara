<?php

namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        // Récupérer toutes les catégories pour les afficher dans le formulaire
        $categories = Category::all();

        // Récupérer tous les tags pour les afficher dans le formulaire
        $tags = Tag::all();

        return view('articles.create', [
            'categories' => $categories,
            'tags' => $tags
        ]);
    }
    public function store(Request $request)
    {
        // Validation des données (si manquant -> redirection avec erreurs)
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'draft' => ['sometimes', 'boolean'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'new_tags' => ['nullable', 'string'],
        ], [
            'title.required' => 'Le titre est requis.',
            'content.required' => 'Le contenu est requis.',
            'categories.*.exists' => 'Une catégorie sélectionnée est invalide.',
            'tags.*.exists' => 'Un tag sélectionné est invalide.',
        ]);

        // On récupère les données validées
        $data = $request->only(['title', 'content', 'draft']);

        // Créateur de l'article (auteur)
        $data['user_id'] = Auth::id();

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On crée l'article
        $article = Article::create($data); // $Article est l'objet article nouvellement créé

        // Synchronisation des catégories sélectionnées dans le formulaire
        $article->categories()->sync($request->input('categories', []));

        // On récupère les tags sélectionnés via les cases à cocher
        $tagIds = $request->input('tags', []);

        // Gestion des nouveaux tags saisis manuellement (séparés par des virgules)
        $newTagsString = $request->input('new_tags');
        if (!empty($newTagsString)) {
            // On sépare la chaîne par les virgules et on nettoie les espaces
            $names = array_map('trim', explode(',', $newTagsString));
            foreach ($names as $name) {
                if ($name) {
                    // On crée le tag s'il n'existe pas, ou on le récupère
                    $tag = Tag::firstOrCreate(['name' => $name]);
                    $tagIds[] = $tag->id;
                }
            }
        }

        // Synchronisation finale de tous les tags (existants + nouveaux), sans doublons
        $article->tags()->sync(array_unique($tagIds));

        // On redirige l'utilisateur vers la liste des articles
        return redirect()->route('dashboard')->with('success', 'Article créé avec succès.');
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
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        // Récupérer toutes les catégories pour les afficher dans le formulaire
        $categories = Category::all();

        // Récupérer tous les tags pour les afficher dans le formulaire
        $tags = Tag::all();

        // On retourne la vue avec l'article, les catégories et les tags
        return view('articles.edit', [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function update(Request $request, Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }

        // Validation des données (si manquant -> redirection avec erreurs)
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'draft' => ['sometimes', 'boolean'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'new_tags' => ['nullable', 'string'],
        ], [
            'title.required' => 'Le titre est requis.',
            'content.required' => 'Le contenu est requis.',
            'categories.*.exists' => 'Une catégorie sélectionnée est invalide.',
            'tags.*.exists' => 'Un tag sélectionné est invalide.',
        ]);

        // On récupère les données validées
        $data = $request->only(['title', 'content', 'draft']);

        // Gestion du draft
        $data['draft'] = isset($data['draft']) ? 1 : 0;

        // On met à jour l'article
        $article->update($data);

        // Synchronisation des catégories sélectionnées dans le formulaire
        $article->categories()->sync($request->input('categories', []));

        // On récupère les tags sélectionnés via les cases à cocher
        $tagIds = $request->input('tags', []);

        // Gestion des nouveaux tags saisis manuellement (séparés par des virgules)
        $newTagsString = $request->input('new_tags');
        if (!empty($newTagsString)) {
            // On sépare la chaîne par les virgules et on nettoie les espaces
            $names = array_map('trim', explode(',', $newTagsString));
            foreach ($names as $name) {
                if ($name) {
                    // On crée le tag s'il n'existe pas, ou on le récupère
                    $tag = Tag::firstOrCreate(['name' => $name]);
                    $tagIds[] = $tag->id;
                }
            }
        }

        // Synchronisation finale de tous les tags (existants + nouveaux), sans doublons
        $article->tags()->sync(array_unique($tagIds));

        // On redirige l'utilisateur vers la liste des articles (avec un flash)
        return redirect()->route('dashboard')->with('success', 'Article mis à jour !');
    }

    public function remove(Article $article) {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::id()) {
            abort(403);
        }
        return view('articles.remove', ['article' => $article]);
    }

    public function destroy(Article $article)
    {
        // On vérifie que l'utilisateur est bien le créateur de l'article
        if ($article->user_id !== Auth::id()) {
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
