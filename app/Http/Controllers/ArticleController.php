<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function like(Article $article)
    {
        $user = auth()->user();
        
        $article->likers()->toggle($user->id);
        
        $article->update([
            'likes' => $article->likers()->count()
        ]);

        return redirect()->back();
    }
}