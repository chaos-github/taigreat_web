@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => '最新消息 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261718480000001.jpg', 'heading' => '最新消息', 'en' => 'NEWS'])

    <section class="page-section">
        <div class="wrap news-list-grid">
            <a class="news-card" href="https://money.udn.com/money/story/5721/8421484" target="_blank" rel="noopener">
                <img src="{{ $a }}/upload/news/2501061753420000001.jpg" alt="建材展-MFE 鋁合金系統模板台灣獨家代理">
                <time>2024.12.20　媒體報導</time>
                <h3>建材展-MFE 鋁合金系統模板台灣獨家代理</h3>
            </a>
        </div>
    </section>
@endsection
