<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function like(Article $article)
    {
        $user = auth()->user();
        
        $results = $article->likers()->toggle($user->id);
        $liked = count($results['attached']) > 0;
        
        $count = $article->likers()->count();
        $article->update(['likes' => $count]);

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $count
        ]);
    }
}