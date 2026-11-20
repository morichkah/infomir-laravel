<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::query()->orderByDesc('date')->paginate(6);
        return response()->json($articles);
    }

    public function show(Article $article)
    {
        $article->load('comments.user');
        return response()->json($article);
    }

    public function store(ArticleRequest $request)
    {
        $article = Article::create($request->validated());
        return response()->json([
            'message' => 'Статья успешно создана',
            'article' => $article
        ], 201);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($request->validated());
        return response()->json([
            'message' => 'Статья обновлена',
            'article' => $article
        ]);
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['message' => 'Статья удалена']);
    }
}

