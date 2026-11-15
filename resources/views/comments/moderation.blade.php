@extends('layouts.app')

@section('title', 'Модерация комментариев')

@section('content')
    <h1>Модерация комментариев</h1>
    <p>Здесь отображаются комментарии, которые еще не прошли проверку.</p>

    @if(count($comments) === 0)
        <div class="flash" style="background:#f1f5f9; color:var(--muted); border-color:var(--line);">
            Нет комментариев, ожидающих модерации.
        </div>
    @else
        <div style="display:flex; flex-direction:column; gap:20px; margin-top:20px;">
            @foreach($comments as $comment)
                <div style="border: 1px solid var(--line); border-radius: 12px; padding: 20px; background: #fff;">
                    <div style="display:flex; justify-content:space-between; margin-bottom: 10px;">
                        <strong>{{ $comment->user->name }}</strong>
                        <span style="color:var(--muted); font-size:0.9rem;">К статье: {{ $comment->article->name }}</span>
                    </div>
                    <p style="background: #f8fafc; padding: 12px; border-radius: 8px; border-left: 4px solid var(--accent);">
                        {{ $comment->body }}
                    </p>
                    
                    <div class="crud-actions" style="margin-top: 15px;">
                        <!-- Кнопка Одобрить -->
                        <form action="{{ route('comments.approve', $comment) }}" method="POST" style="margin:0;">
                            @csrf
                            <button type="submit" class="btn">Одобрить</button>
                        </form>
                        
                        <!-- Кнопка Отклонить -->
                        <form action="{{ route('comments.reject', $comment) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Отклонить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection