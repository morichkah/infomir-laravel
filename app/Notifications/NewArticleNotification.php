<?php

namespace App\Notifications;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewArticleNotification extends Notification
{
    use Queueable;

    public $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    // Настраиваем каналы (только база данных)
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Данные, которые сохранятся в базу (в формате массива)
    public function toArray(object $notifiable): array
    {
        return [
            'article_id' => $this->article->id,
            'article_name' => $this->article->name,
            'message' => 'Опубликована новая статья: ' . $this->article->name,
        ];
    }
}