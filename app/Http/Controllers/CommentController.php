<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Article;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        // Validation des données reçues du formulaire
        $validated = $request->validate([
            'content' => 'required|string',
            'articleId' => 'required|exists:articles,id',
        ]);

        // Récupération de l'article pour la redirection
        $article = Article::findOrFail($validated['articleId']);

        if (Auth::check()) {
        // Création du commentaire dans la base de données
        Comment::create([
            'content' => $validated['content'],        
            'article_id' => $validated['articleId'],  
            'user_id' => Auth::user()->id              
        ]);
    }

        // Redirection vers la page de l'article qu'on vient de commenter
        return redirect()->route('public.show', [
            'user' => $article->user_id,
            'article' => $article->id
        ])->with('success', 'Commentaire ajouté avec succès !');
    }
} 
