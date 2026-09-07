@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => '最新消息 | 泰權興貿易'])

@section('header')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261718480000001.jpg', 'heading' => '最新消息', 'en' => 'NEWS'])
@endsection

@section('content')
    <section>
        <div class="container-md">
            <div class="row">
                <div class="col-lg-12">
                    <div class="news_list">
                        <ul>
                            <li class="active"><a href="{{ route('news') }}">全部</a></li>
                            <li><a href="{{ route('news') }}">最新消息</a></li>
                            <li><a href="{{ route('news') }}">媒體報導</a></li>
                            <li><a href="{{ route('news') }}">活動展覽</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="in_n_items n_items">
                        <a href="https://money.udn.com/money/story/5721/8421484" target="_blank" rel="noopener">
                            <img src="{{ $a }}/upload/news/2501061753420000001.jpg" class="img-fluid" alt="建材展-MFE 鋁合金系統模板台灣獨家代理">
                            <div class="in_n_bottom">
                                <time>2024.12.20</time>
                                <span>媒體報導</span>
                                <i></i>
                                <h3>建材展-MFE 鋁合金系統模板台灣獨家代理</h3>
                                <em>MORE</em>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
