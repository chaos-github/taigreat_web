@php
    $hero = \App\Support\OptimizedImage::url('upload/adv/2407261159140000001.jpg');
@endphp
@extends('layouts.site')

@push('head')
    <link rel="preload" as="image" href="{{ $hero }}" fetchpriority="high">
@endpush

@section('content')
    <section class="hero" aria-labelledby="hero-title">
        <div class="hero__visual">
            <img src="{{ $hero }}" alt="玻璃帷幕建築映照城市天空" width="1920" height="1279" fetchpriority="high" decoding="async">
        </div>
        <div class="wrap hero__inner">
            <div class="hero__copy">
                <p class="eyebrow"><span class="accent-line"></span> Materials. Methods. Possibilities.</p>
                <h1 id="hero-title">以專業建構<br>建築的<span>更多可能。</span></h1>
                <p class="hero__description">從材料選用到工法整合，讓每一個工程構想，<br class="desktop-break">都有更扎實的實現方式。</p>
                <div class="hero__actions">
                    <a class="btn btn-gold" href="{{ route('service') }}">探索產品與服務 <span aria-hidden="true">↗</span></a>
                    <a class="hero__secondary" href="{{ route('case') }}">觀看工程實績 <span aria-hidden="true">→</span></a>
                </div>
            </div>
            <div class="hero__caption"><span>TAIGREAT TRADING</span><span>專業建材・創新工法・整合服務</span></div>
        </div>
        <a class="hero__scroll" href="#expertise">向下探索 <span aria-hidden="true">↓</span></a>
    </section>

    <section class="expertise-strip" id="expertise" aria-label="核心服務">
        <div class="wrap expertise-grid">
            @foreach ([['01', '材料整合', '依工程需求，連結合適的建材與系統'], ['02', '技術應用', '讓產品特性與現場工法相互配合'], ['03', '專案協作', '從前期討論到工程應用，持續溝通']] as [$number, $heading, $description])
                <div class="expertise-item"><span>{{ $number }}</span><div><h2>{{ $heading }}</h2><p>{{ $description }}</p></div></div>
            @endforeach
        </div>
    </section>

    <section class="about-block band">
        <div class="wrap about-grid">
            <div class="about-photo">
                <img src="{{ \App\Support\OptimizedImage::url('images/a_pic.jpg') }}" alt="建築結構與材料應用" width="552" height="460" loading="lazy" decoding="async">
                <div class="photo-note"><span>OUR APPROACH</span><p>讓好材料，<br>成就好建築。</p></div>
            </div>
            <div class="about-copy">
                <p class="eyebrow">01 / About Taigreat</p>
                <h2>理解工程需求，<br>找到更好的建築解方。</h2>
                <p class="section-lead">專業，始於對每一個細節的理解。</p>
                <p>泰權興貿易專注於建築材料與創新工法，整合國內外產品與技術，協助工程團隊評估材料選用、施工應用及專案需求。</p>
                <p>從系統模板、水泥複合材料，到節能與防水應用，我們重視的不只是產品本身，更是材料如何在現場發揮價值。</p>
                <a class="link-arrow" href="{{ route('about') }}">認識泰權興 <span aria-hidden="true">↗</span></a>
            </div>
        </div>
    </section>

    <section class="band band-paper">
        <div class="wrap">
            <div class="section-head">
                <div><p class="eyebrow">02 / Our expertise</p><h2>產品與服務</h2><p class="section-kicker">以材料為基礎，以應用為核心，回應不同階段的工程需求。</p></div>
                <a class="link-arrow" href="{{ route('service') }}">瀏覽完整服務 <span aria-hidden="true">↗</span></a>
            </div>
            <div class="card-grid">
                @forelse ($featuredServices as $service)
                    <a class="photo-card" href="{{ route('service') }}#service-{{ $service->id }}">
                        <div class="card-image"><img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}" width="600" height="450" loading="lazy" decoding="async"><span class="card-index">0{{ $loop->iteration }}</span></div>
                        <div class="photo-card__body"><h3>{{ $service->title }}</h3><p>{{ \Illuminate\Support\Str::limit(strip_tags($service->description), 64) }}</p><span class="card-link">了解服務 <span aria-hidden="true">↗</span></span></div>
                    </a>
                @empty
                    <p class="empty-state">產品資訊整理中，歡迎聯絡我們討論您的工程需求。</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="band projects-section">
        <div class="wrap">
            <div class="section-head">
                <div><p class="eyebrow">03 / Selected projects</p><h2>專業，落實在每一個現場。</h2><p class="section-kicker">從在地建設到國際工程，探索材料與工法的實際應用。</p></div>
                <a class="link-arrow" href="{{ route('case') }}">所有工程實績 <span aria-hidden="true">↗</span></a>
            </div>
            <div class="project-grid">
                @forelse ($featuredCases as $case)
                    <a class="project-card" href="{{ route('case', ['category' => $case->category->slug]) }}">
                        <div class="card-image"><img src="{{ $case->imageUrl() }}" alt="{{ $case->title }}" width="970" height="720" loading="lazy" decoding="async"><span class="project-card__arrow" aria-hidden="true">↗</span></div>
                        <span class="project-category">{{ $case->category->name }}</span><h3>{{ $case->title }}</h3>
                    </a>
                @empty
                    <p class="empty-state">工程實績持續更新中。</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="sustain" aria-labelledby="sustain-title">
        <div class="sustain__media"><img src="{{ \App\Support\OptimizedImage::url('images/bg.jpg') }}" alt="自然環境與永續建築願景" width="1600" height="900" loading="lazy" decoding="async"></div>
        <div class="wrap sustain__inner">
            <div class="sustain__copy"><p class="eyebrow">04 / A better tomorrow</p><h2 id="sustain-title">為建築創造價值，<br>也為未來保留可能。</h2><p>把材料生命週期、施工效率與環境影響納入思考，從每一次選擇，逐步推進更永續的建築方式。</p><a class="link-arrow" href="{{ route('sustainability') }}">了解永續理念 <span aria-hidden="true">↗</span></a></div>
            <div class="sustain__principles">
                @foreach ([['01', '材料循環', '重視材料利用效率與生命週期'], ['02', '工程協作', '與工程夥伴共同關注品質與安全'], ['03', '節能思維', '探索建築節能與環境友善的應用']] as [$number, $heading, $text])
                    <div><span>{{ $number }}</span><div><h3>{{ $heading }}</h3><p>{{ $text }}</p></div></div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="band news-block">
        <div class="wrap">
            <div class="section-head"><div><p class="eyebrow">05 / Insights & updates</p><h2>泰權興新訊</h2><p class="section-kicker">掌握產品應用、企業動態與產業消息。</p></div><a class="link-arrow" href="{{ route('news') }}">所有最新消息 <span aria-hidden="true">↗</span></a></div>
            <div class="news-grid">
                @forelse ($latestNews as $item)
                    <a class="news-card" href="{{ $item->url ?: route('news') }}" @if ($item->url) target="_blank" rel="noopener" @endif>
                        <div class="card-image"><img src="{{ $item->imageUrl() }}" alt="{{ $item->title }}" width="640" height="400" loading="lazy" decoding="async"></div>
                        <div class="news-card__body"><time datetime="{{ $item->published_on->format('Y-m-d') }}">{{ $item->publishedLabel() }} <span>{{ $item->category->name }}</span></time><h3>{{ $item->title }}</h3><span class="card-link">閱讀消息 <span aria-hidden="true">↗</span></span></div>
                    </a>
                @empty
                    <p class="empty-state">最新消息持續更新中。</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
