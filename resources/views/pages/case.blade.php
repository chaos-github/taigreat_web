@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => $title ?? '工程實績 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261546490000001.jpg', 'heading' => '工程實績', 'en' => 'PROJECTS'])

    <section class="page-section">
        <div class="wrap">
            <div class="filters">
                <a href="{{ route('case') }}" class="{{ $currentSlug === '' ? 'is-active' : '' }}">全部</a>
                @foreach ($categories as $category)
                    <a href="{{ route('case', ['category' => $category->slug]) }}" class="{{ $currentSlug === $category->slug ? 'is-active' : '' }}">{{ $category->name }}</a>
                @endforeach
            </div>

            <div class="case-grid">
                @forelse ($cases as $case)
                    <article class="case-card">
                        <img src="{{ $case->imageUrl() }}" alt="{{ $case->title }}">
                        <span class="eyebrow" style="margin-top:0.8rem;display:block">{{ $case->category->name }}</span>
                        <h3>{{ $case->title }}</h3>
                    </article>
                @empty
                    <p>目前沒有案例資料。</p>
                @endforelse
            </div>

            {{ $cases->onEachSide(2)->links('pagination.site') }}
        </div>
    </section>
@endsection
