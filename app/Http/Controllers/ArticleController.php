<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Mail\NewArticleMail;
use App\Models\Article;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Article::class);

        $page = request('page', 1);
        $perPage = 6;
        $articleIds = Cache::remember('articles_ids_page_' . $page, 600, function () use ($page, $perPage) {
            return Article::query()
                ->orderByDesc('date')
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->pluck('id')
                ->toArray();
        });

        $articlesData = Article::whereIn('id', $articleIds)->orderByDesc('date')->get();

        $total = Cache::remember('articles_total_count', 600, function () {
            return Article::count();
        });

        $articles = new \Illuminate\Pagination\LengthAwarePaginator(
            $articlesData,
            $total,
            $perPage,
            $page,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $this->authorize('create', Article::class);

        return view('articles.create');
    }

    public function store(ArticleRequest $request)
    {
        $this->authorize('create', Article::class);
        
        $article = Article::create($request->validated());
        
        $emails = User::query()
            ->whereHas('role', fn ($query) => $query->where('slug', Role::MODERATOR))
            ->pluck('email');

        if ($notify = env('MAIL_MODERATOR_ADDRESS')) {
            $emails->push($notify);
        }

        foreach ($emails->unique()->filter() as $email) {
            Mail::to($email)->queue(new NewArticleMail($article));
        }
        
        $readers = User::query()
            ->whereHas('role', fn ($query) => $query->where('slug', Role::READER))
            ->get();

        Notification::send($readers, new \App\Notifications\NewArticleNotification($article));
  
        event(new \App\Events\NewArticleEvent($article));

        Cache::flush();
        return redirect()
            ->route('articles.show', $article)
            ->with('success', 'Статья создана, уведомление отправлено модератору');
    }

    public function show(Article $article)
    {
        $this->authorize('view', $article);

        $cachedData = Cache::rememberForever('article_data_' . $article->id, function () use ($article) {
            return [
                'article' => $article->toArray(),
                'comments' => $article->comments()->with('user')->get()->toArray(),
            ];
        });
        $articleData = new \App\Models\Article($cachedData['article']);
        $articleData->id = $article->id;
        $article = $article->setRawAttributes($cachedData['article']);
        $comments = collect($cachedData['comments'])->map(function($commentData) {
            return new \App\Models\Comment($commentData);
        });
        $article->setRelation('comments', $comments);

        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);

        return view('articles.edit', compact('article'));
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article);

        $article->update($request->validated());

        Cache::flush();
        return redirect()
            ->route('articles.show', $article)
            ->with('success', 'Статья обновлена');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);

        $article->delete();

        Cache::flush();
        return redirect()
            ->route('articles.index')
            ->with('success', 'Статья удалена');
    }
}