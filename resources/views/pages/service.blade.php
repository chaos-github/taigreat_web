@extends('layouts.site', ['title' => $title ?? '產品與服務 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261549360000001.jpg', 'heading' => '產品與服務', 'en' => 'SERVICE'])

    <section class="page-section">
        <div class="wrap">
            <div class="page-intro"><p class="eyebrow">Materials & solutions</p><h2>從材料選用，走向工程應用。</h2><p>探索系統模板、複合材料與建築應用技術。歡迎與我們討論使用條件、施工方式及專案需求，找到合適的整合方案。</p></div>
            <div class="service-grid">
                @forelse ($services as $service)
                    <article class="service-card" id="service-{{ $service->id }}">
                        <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}" width="640" height="400" loading="lazy" decoding="async">
                        <i>{{ $service->number }}</i>
                        <h3>{{ $service->title }}</h3>
                        <p>{{ $service->safeDescription() }}</p>
                        @foreach ($service->links ?? [] as $link)
                            <a href="{{ $link['url'] }}" target="_blank" rel="noopener">{{ $link['label'] }}</a>
                        @endforeach
                    </article>
                @empty
                    <p>目前沒有服務項目。</p>
                @endforelse
            </div>

            {{ $services->onEachSide(2)->links('pagination.site') }}
        </div>
    </section>
@endsection
