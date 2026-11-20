@extends('layouts.app')

@section('title', 'Уведомления')

@section('content')
    <h1>Уведомления</h1>
    @forelse($notifications as $notification)
        <div style="border-bottom: 1px solid #ccc; padding: 15px 0;">
            <a href="{{ route('articles.show', $notification->data['article_id']) }}" style="font-size: 1.1rem; font-weight: bold; color: var(--accent);">
                {{ $notification->data['message'] }}
            </a>
            <small style="color: gray; display: block; margin-top: 5px;">{{ $notification->created_at->diffForHumans() }}</small>
        </div>
    @empty
        <p>У вас пока нет уведомлений.</p>
    @endforelse
    
    <div style="margin-top: 20px;">
        {{ $notifications->links() }}
    </div>
@endsection