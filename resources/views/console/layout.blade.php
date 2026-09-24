{{-- 後台版型：左側選單 + 內容區 --}}
@php
    $nav = [
        ['console.dashboard', ['console.dashboard'], '總覽', 'Dashboard'],
        ['console.cases.index', ['console.cases.*', 'console.case-categories.*'], '工程實績', 'Cases'],
        ['console.news.index', ['console.news.*', 'console.news-categories.*'], '最新消息', 'News'],
        ['console.services.index', ['console.services.*'], '產品與服務', 'Services'],
    ];
@endphp
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '內容中心' }} | 泰權興貿易</title>
    <link rel="icon" href="{{ asset('assets/taigreat/images/favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&family=Noto+Sans+TC:wght@300;400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/console.css', 'resources/js/console.js'])
</head>
<body class="console-app">
    <aside class="console-sidebar" data-console-sidebar>
        <a class="console-brand" href="{{ route('console.dashboard') }}">
            <img src="{{ asset('assets/taigreat/images/logo_tgc.svg') }}" alt="恆展堂建築 TAIGREAT CONSTRUCTION">
            <small>內容中心</small>
        </a>
        <nav>
            @foreach ($nav as [$route, $matches, $label, $en])
                <a href="{{ route($route) }}" class="{{ request()->routeIs(...$matches) ? 'is-active' : '' }}">
                    <span>{{ $label }}</span>
                    <small>{{ $en }}</small>
                </a>
            @endforeach
        </nav>
    </aside>

    <div class="console-main">
        <header class="console-topbar">
            <button class="console-menu" type="button" data-console-toggle aria-label="開啟選單">選單</button>
            <div>
                <p class="console-topbar__kicker">Content Console</p>
                <h1>{{ $heading ?? $title ?? '內容中心' }}</h1>
            </div>
            <div class="console-topbar__actions">
                <a href="{{ route('home') }}" target="_blank" rel="noopener">查看官網</a>
                <span>{{ auth()->user()->name }}</span>
                <form method="post" action="{{ route('console.logout') }}">
                    @csrf
                    <button type="submit">登出</button>
                </form>
            </div>
        </header>

        <div class="console-content">
            @if (session('status'))
                <div class="console-alert console-alert--ok">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="console-alert console-alert--error">{{ $errors->first() }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
