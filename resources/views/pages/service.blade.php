@extends('layouts.site', ['title' => $title ?? '產品與服務 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261549360000001.jpg', 'heading' => '產品與服務', 'en' => 'SERVICE'])

    <section class="page-section">
        <div class="wrap">
            <div class="service-grid">
                @forelse ($services as $service)
                    <article class="service-card">
                        <img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}">
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
