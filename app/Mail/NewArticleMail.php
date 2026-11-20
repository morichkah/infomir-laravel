<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewArticleMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Article $article)
    {
    }

    public function build(): self
    {
        return $this
            ->subject('Новая статья: '.$this->article->name)
            ->view('mail.new-article');
    }
}
