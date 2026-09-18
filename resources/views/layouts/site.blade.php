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
            <svg width="28" height="28" viewBox="0 0 32 32" aria-hidden="true">
                <path d="M16 3 L30 27 H2 Z" fill="#0c2233"/>
            </svg>
            <span>
                <strong>TAIGREAT <br> CONSTRUCTION</strong>
                <small>恆展堂建築有限公司</small>
            </span>
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
            <a class="brand" href="{{ route('home') }}">
                <svg width="26" height="26" viewBox="0 0 32 32" aria-hidden="true">
                    <path d="M16 3 L30 27 H2 Z" fill="#ffffff"/>
                </svg>
                <span>
                    <strong style="color:#fff">TAIGREAT CONSTRUCTION</strong>
                    <small style="color:rgba(255,255,255,.65)">恆展堂建築有限公司</small>
                </span>
            </a>
            <nav>
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
