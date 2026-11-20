@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
    <h1>Контакты</h1>
    <p>Контакты для связи.</p>

    <ul class="contacts">
        @foreach ($contacts as $item)
            <li>
                <strong>{{ $item['label'] }}</strong>
                <span>{{ $item['value'] }}</span>
            </li>
        @endforeach
    </ul>
@endsection
