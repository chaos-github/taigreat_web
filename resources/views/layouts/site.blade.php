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
    <meta name="description" content="{{ $description ?? '泰權興貿易整合建築材料與創新工法，提供系統模板、複合材料、節能及防水應用的產品與技術服務，與工程夥伴共同實現建築價值。' }}">
    <meta name="theme-color" content="#102c36">
    <title>{{ str_replace('泰權興貿易', '恆展堂建築', $title ?? '恆展堂建築') }}</title>
    <link rel="icon" type="image/svg+xml" sizes="any" href="{{ $a }}/images/favicon-hengtang.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600&family=Noto+Sans+TC:wght@400;500;600;700&display=swap" rel="stylesheet">
    @stack('head')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="{{ request()->routeIs('home') ? 'is-home' : 'is-inner' }}">
<a class="skip-link" href="#main-content">跳至主要內容</a>
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
        </div>
        <button class="nav-toggle" type="button" data-nav-toggle aria-expanded="false" aria-label="開啟選單" aria-controls="site-drawer">
            <span></span>
        </button>
    </div>
    <div class="site-drawer" id="site-drawer" data-nav-drawer>
        @foreach ($nav as [$name, $label])
            <a href="{{ route($name) }}">{{ $label }}</a>
        @endforeach
    </div>
</header>

<main id="main-content" tabindex="-1">
    @yield('content')
</main>

@if (! request()->routeIs('contact'))
    <section class="project-cta" aria-labelledby="cta-title">
        <div class="wrap project-cta__inner">
            <div><p class="eyebrow">Let's build together</p><h2 id="cta-title">您的下一個專案，<br>從一次對話開始。</h2><p>與我們分享您的工程需求，一起找到合適的材料與工法。</p></div>
            <a class="btn btn-gold" href="{{ route('contact') }}">與我們討論專案 <span aria-hidden="true">↗</span></a>
        </div>
    </section>
@endif

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
            <p>© {{ now()->year }} Taigreat Trading Co., Ltd. All Rights Reserved.</p>
            <p>406台中市北屯區昌平東二路156號　04-24220159　info@taigreat.com.tw</p>
        </div>
    </div>
</footer>
</body>
</html>
