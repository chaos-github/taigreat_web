@extends('layouts.site', ['title' => $title ?? '最新消息 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261718480000001.jpg', 'heading' => '最新消息', 'en' => 'NEWS'])

    <section class="page-section">
        <div class="wrap">
            <div class="filters">
                <a href="{{ route('news') }}" class="{{ $currentSlug === '' ? 'is-active' : '' }}">全部</a>
                @foreach ($categories as $category)
                    <a href="{{ route('news', ['category' => $category->slug]) }}" class="{{ $currentSlug === $category->slug ? 'is-active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="news-list-grid">
                @forelse ($news as $item)
                    <a class="news-card" href="{{ $item->url ?: route('news') }}" @if ($item->url) target="_blank" rel="noopener" @endif>
                        <img src="{{ $item->imageUrl() }}" alt="{{ $item->title }}">
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
