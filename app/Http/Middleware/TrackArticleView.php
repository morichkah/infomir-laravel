<?php

namespace App\Http\Middleware;

use App\Models\Article;
use App\Models\ArticleView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackArticleView
{
    public function handle(Request $request, Closure $next): Response
    {
      
        $article = $request->route('article');
        
        if ($article instanceof Article && !session()->has('viewed_article_' . $article->id)) {            
            ArticleView::create([
                'article_id' => $article->id,
                'ip_address' => $request->ip(),
            ]);            
            session()->put('viewed_article_' . $article->id, true);
        }

        return $next($request);
    }
}