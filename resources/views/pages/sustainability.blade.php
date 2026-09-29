@extends('layouts.site', ['title' => $page->title])

@section('content')
    @include('partials.page-banner', ['image' => $page->banner_image, 'heading' => $page->heading, 'en' => $page->heading_en])

    <section class="page-section">
        <div class="wrap split-page">
            <img src="{{ $page->imageUrl() }}" alt="{{ $page->heading }}">
            <div class="prose-page">
                <p class="eyebrow">{{ $page->eyebrow }}</p>
                <h3>{{ $page->subtitle }}</h3>
                <p>{{ $page->safeBody() }}</p>
                <div class="stats" style="margin-top:2rem">
                    @foreach ($page->stats() as $stat)
                        <div>
                            <b>{{ $stat['title'] }}</b>
                            <small>{{ $stat['text'] }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
