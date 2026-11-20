<?php

namespace App\Console\Commands;

use App\Models\ArticleView;
use App\Models\Comment;
use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyStats extends Command
{
    protected $signature = 'stats:send';
    protected $description = 'Отправка статистики модераторам';

    public function handle()
    {
        $viewsCount = ArticleView::whereDate('created_at', today())->count();
        
        $commentsCount = Comment::whereDate('created_at', today())->count();

        $text = "Статистика за сегодня:\n";
        $text .= "Просмотров статей: {$viewsCount}\n";
        $text .= "Новых комментариев: {$commentsCount}\n";
        
        $moderators = User::whereHas('role', fn($q) => $q->where('slug', Role::MODERATOR))->get();

        foreach ($moderators as $moderator) {
            Mail::raw($text, function ($message) use ($moderator) {
                $message->to($moderator->email)
                        ->subject('Ежедневная статистика сайта ИнфоМир');
            });
        }

        $this->info('Статистика отправлена!');
    }
}