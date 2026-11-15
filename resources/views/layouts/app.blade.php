<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Сайт') — ИнфоМир</title>
    <style>
        :root {
            /* Лавандовая гамма */
            --bg: #f5f3ff;         /* Очень светлый сиренево-серый фон */
            --paper: #ffffff;      /* Белые карточки */
            --ink: #1e1b4b;        /* Темно-фиолетовый текст */
            --muted: #64748b;      /* Серый текст */
            --accent: #7c3aed;     /* Глубокий фиолетовый (для меню) */
            --accent-hover: #6d28d9;
            --line: #e2e8f0;       /* Светлые рамки */
            
            /* Цвета для кнопок форм (из старого дизайна) */
            --btn-form: #2f5d50;   
            --btn-form-hover: #24483e;
        }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; }
        body {
            font-family: Verdana, Geneva, sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        a { color: var(--accent); text-decoration: none; transition: 0.3s; }
        a:hover { color: var(--accent-hover); text-decoration: underline; }
        
        /* --- Шапка (Логотип по центру) --- */
        .site-header {
            background: var(--paper);
            border-bottom: 1px solid var(--line);
            box-shadow: 0 2px 10px rgba(124, 58, 237, 0.05);
        }
        .header-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            width: min(1100px, calc(100% - 32px));
            margin: 0 auto;
        }
        .logo {
            font-weight: 700;
            color: var(--accent);
            letter-spacing: .05em;
            font-size: 1.4rem;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .nav-left, .nav-right {
            display: flex;
            gap: 4px;
            align-items: center;
            flex: 1;
        }
        .nav-left { justify-content: flex-start; }
        .nav-right { justify-content: flex-end; }
        
        nav a {
            padding: 8px 12px;
            border-radius: 8px;
            color: var(--ink);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }
        nav a:hover, nav a.active {
            background: #f3e8ff;
            color: var(--accent);
            text-decoration: none;
        }
        
        /* Основной контент */
        .container { width: min(1100px, calc(100% - 32px)); margin: 0 auto; }
        main { padding: 32px 0 48px; }
        .card {
            background: var(--paper);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 30px rgba(124, 58, 237, 0.04);
        }
        h1 { margin: 0 0 12px; font-size: 2rem; color: var(--ink); }
        p { line-height: 1.6; color: var(--muted); }
        
        /* Контакты */
        .contacts { list-style: none; padding: 0; margin: 20px 0 0; }
        .contacts li {
            display: grid;
            grid-template-columns: 140px 1fr;
            gap: 12px;
            padding: 12px 0;
            border-top: 1px solid var(--line);
        }
        .contacts strong { color: var(--ink); }
        .site-footer { background: var(--paper); border-top: 1px solid var(--line); margin-top: auto; }
        .site-footer .container { padding: 18px 0; color: var(--muted); font-size: .95rem; text-align: center; }
        
        /* Сетка новостей (стандартная) */
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 24px;
        }
        .news-card {
            border: 1px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s;
        }
        .news-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(124, 58, 237, 0.08); }
        .news-card img { width: 100%; height: 200px; object-fit: cover; display: block; }
        .news-body { padding: 20px; flex-grow: 1; }
        .news-body time { color: var(--accent); font-size: .85rem; font-weight: bold; text-transform: uppercase; }
        .news-body h2 { margin: 8px 0; font-size: 1.2rem; color: var(--ink); }
        .full-image { width: 100%; max-height: 520px; object-fit: cover; border-radius: 12px; margin: 20px 0; }

        /* --- ФОРМЫ ВХОДА И РЕГИСТРАЦИИ (Как в старом дизайне) --- */
        .auth-form { display: grid; gap: 14px; max-width: 420px; margin-top: 20px; }
        .auth-form label { display: grid; gap: 6px; color: var(--ink); font-weight: 600; }
        .auth-form input {
            padding: 10px 12px;
            border: 1px solid var(--line);
            border-radius: 8px;
            font: inherit;
            background: #fff;
        }
        .auth-form input:focus { outline: none; border-color: var(--btn-form); }
        
        /* Кнопки в формах (темно-зеленые, как раньше) */
        .auth-form button {
            margin-top: 8px;
            padding: 12px 14px;
            border: 0;
            border-radius: 8px; /* Вернули закругление */
            background: var(--btn-form);
            color: #fff;
            font: inherit;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
        }
        .auth-form button:hover { background: var(--btn-form-hover); }
        
        .error { color: #ef4444; font-weight: 400; font-size: .9rem; }
        
        /* Остальные кнопки (CRUD) */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            background: var(--accent);
            color: #fff !important;
            text-decoration: none !important;
            border: 0;
            font: inherit;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn:hover { background: var(--accent-hover); transform: translateY(-2px); }
        .btn-danger { background: #ef4444; }
        .btn-danger:hover { background: #dc2626; }
        
        .crud-actions { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin-top: 15px; }
        .crud-actions form { margin: 0; }
        .linkish { background: none; border: 0; padding: 0; color: #ef4444; cursor: pointer; font: inherit; font-weight:bold; text-decoration: underline; }
        .flash {
            background: #f3e8ff; border: 1px solid #d8b4fe; color: var(--accent);
            padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;
        }
        .pagination-wrap { margin-top: 30px; }
        .pagination-wrap nav, .pagination-wrap ul { display: flex; gap: 8px; flex-wrap: wrap; list-style: none; padding: 0; justify-content: center; }
        .pagination-wrap a, .pagination-wrap span { padding: 8px 14px; border-radius: 8px; border: 1px solid var(--line); font-weight: bold; }
        
        @media (max-width: 768px) {
            .header-wrapper { flex-direction: column; gap: 16px; }
            .nav-left, .nav-right { justify-content: center; flex-wrap: wrap; }
            .contacts li { grid-template-columns: 1fr; gap: 4px; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-wrapper">
            <div class="nav-left">
                <nav>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
                    <a href="{{ route('articles.index') }}" class="{{ request()->routeIs('articles.*') ? 'active' : '' }}">Новости БД</a>
                </nav>
            </div>
            
            <a class="logo" href="{{ route('home') }}">ИнфоМир</a>
            
            <div class="nav-right">
                <nav>
                    @can('create', App\Models\Article::class)
                        <a href="{{ route('articles.create') }}" class="{{ request()->routeIs('articles.create') ? 'active' : '' }}">Создать</a>
                    @endcan
                    @if(auth()->check() && auth()->user()->role && auth()->user()->role->slug === 'moderator')
                        <a href="{{ route('comments.moderation') }}" class="{{ request()->routeIs('comments.*') ? 'active' : '' }}">Модерация</a>
                    @endif
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">О нас</a>
                    <a href="{{ route('contacts') }}" class="{{ request()->routeIs('contacts') ? 'active' : '' }}">Контакты</a>
                    
                    @auth
                        <div style="display:flex; align-items:center; gap:10px; margin-left: 15px; border-left: 1px solid var(--line); padding-left: 15px;">
                            <span style="font-weight: bold; margin-left: 10px; color: var(--accent);">{{ auth()->user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                @csrf
                                <button type="submit" class="linkish" style="color:var(--muted); margin-left:10px;">Выход</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Вход</a>
                        <a href="{{ route('signin') }}" class="{{ request()->routeIs('signin') ? 'active' : '' }}">Регистрация</a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="card">
                @if (session('success'))
                    <div class="flash">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="flash" style="background:#fef2f2;color:#991b1b;border-color:#fecaca;">{{ session('error') }}</div>
                @endif
                @yield('content')
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container">
            Жидкова Софья Александровна, 257-321
        </div>
    </footer>
</body>
</html>