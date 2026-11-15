<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Шаг 4: Обновленный store (добавлено is_approved)
    public function store(Request $request, Article $article)
    {
        $this->authorize('create', Comment::class);

        $data = $request->validate([
            'body' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        $article->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $data['body'],
            'is_approved' => false, // Ждет модерации
        ]);

        return back()->with('success', 'Комментарий добавлен и ожидает модерации.');
    }

    // Шаг 4: Новые методы для модератора
    public function moderation()
    {
        $comments = Comment::where('is_approved', false)->with('user', 'article')->latest()->get();
        return view('comments.moderation', compact('comments'));
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Комментарий одобрен.');
    }

    public function reject(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Комментарий отклонен.');
    }

    // Старый метод destroy оставляем без изменений
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Комментарий удалён');
    }
}