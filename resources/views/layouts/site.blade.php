@php
    $a = asset('assets/taigreat');
    $nav = [
        ['home', '首頁'],
        ['about', '關於我們'],
        ['service', '產品與服務'],
        ['case', '工程實績'],
        ['news', '最新消息'],
        ['sustainability', '永續發展'],
        ['contact', '聯絡我們'],
    ];
@endphp
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '泰權興貿易' }}</title>
    <link rel="icon" href="{{ $a }}/images/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&family=Noto+Sans+TC:wght@300;400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header class="site-header">
    <div class="wrap site-header__inner">
        <a class="brand" href="{{ route('home') }}">
            <img class="brand-logo brand-logo--light" src="{{ $a }}/images/logo_tgc.svg" alt="恆展堂建築 TAIGREAT CONSTRUCTION">
        </a>
        <nav class="site-nav" aria-label="主選單">
            @foreach ($nav as [$name, $label])
                <a href="{{ route($name) }}" class="{{ request()->routeIs($name) ? 'is-active' : '' }}">{{ $label }}</a>
            @endforeach
        </nav>
        <div class="site-tools">
            <span class="icon-btn" aria-hidden="true">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <circle cx="11" cy="11" r="7"/><path d="M20 20l-3.2-3.2"/>
                </svg>
            </span>
            <span class="lang">EN</span>
        </div>
        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-label="開啟選單">
            <span></span>
        </button>
    </div>
    <div class="site-drawer" data-nav-drawer>
        @foreach ($nav as [$name, $label])
            <a href="{{ route($name) }}">{{ $label }}</a>
        @endforeach
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="wrap site-footer__inner">
        <div class="site-footer__top">
            <div class="site-footer__marks tw:mx-auto">
                <img src="{{ $a }}/images/footer_logo.svg" alt="恆展堂建築">
                <img src="{{ $a }}/images/footer_logo_2.svg" alt="恆展堂建築">
            </div>
            <nav class="tw:mx-auto">
                @foreach ($nav as [$name, $label])
                    <a href="{{ route($name) }}">{{ $label }}</a>
                @endforeach
            </nav>
        </div>
        <div class="site-footer__bottom">
            <p>© 2024 Taigreat Trading Co., Ltd. All Rights Reserved.</p>
            <p>406台中市北屯區昌平東二路156號　04-24220159　info@taigreat.com.tw</p>
        </div>
    </div>
</footer>
</body>
</html>
