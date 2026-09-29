@extends('layouts.site', ['title' => $page->title])

@section('content')
    @include('partials.page-banner', ['image' => $page->banner_image, 'heading' => $page->heading, 'en' => $page->heading_en])

    <section class="page-section">
        <div class="wrap split-page">
            <img src="{{ $page->imageUrl() }}" alt="{{ $page->subtitle }}">
            <div class="prose-page">
                <p class="eyebrow">{{ $page->eyebrow }}</p>
                <h3>{{ $page->subtitle }}</h3>
                @if (filled($page->lead))
                    <h4>{{ $page->safeLead() }}</h4>
                @endif
                <p>{{ $page->safeBody() }}</p>
            </div>
        </div>
        <div class="wrap">
            <div class="mission">
                <p class="eyebrow">{{ $page->extraValue('mission_eyebrow') }}</p>
                <h3>{{ $page->extraValue('mission_title') }}</h3>
                <p>{{ $page->safeExtra('mission_body') }}</p>
                <p>{{ $page->safeExtra('mission_en') }}</p>
            </div>
        </div>
    </section>
@endsection
