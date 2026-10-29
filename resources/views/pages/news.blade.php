@extends('layouts.site', ['title' => $title ?? '最新消息 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261718480000001.jpg', 'heading' => '最新消息', 'en' => 'NEWS'])

    <section class="page-section">
        <div class="wrap">
            <div class="page-intro"><p class="eyebrow">Insights & updates</p><h2>持續關注，持續向前。</h2><p>在這裡了解泰權興的產品應用、企業動態與媒體報導，掌握我們在建築材料領域的最新進展。</p></div>
            <div class="filters">
                <a href="{{ route('news') }}" class="{{ $currentSlug === '' ? 'is-active' : '' }}">全部</a>
                @foreach ($categories as $category)
                    <a href="{{ route('news', ['category' => $category->slug]) }}" class="{{ $currentSlug === $category->slug ? 'is-active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="news-list-grid">
                @forelse ($news as $item)
                    <a class="news-card" href="{{ $item->url ?: route('news') }}" @if ($item->url) target="_blank" rel="noopener" @endif>
                        <img src="{{ $item->imageUrl() }}" alt="{{ $item->title }}" width="640" height="400" loading="lazy" decoding="async">
                        <time>{{ $item->publishedLabel() }}　{{ $item->category->name }}</time>
                        <h3>{{ $item->title }}</h3>
                    </a>
                @empty
                    <p>目前沒有最新消息。</p>
                @endforelse
            </div>

            {{ $news->onEachSide(2)->links('pagination.site') }}
        </div>
    </section>
@endsection
