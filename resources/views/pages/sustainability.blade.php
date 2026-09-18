@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => '永續發展 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'images/bg.jpg', 'heading' => '永續發展', 'en' => 'SUSTAINABILITY'])

    <section class="page-section">
        <div class="wrap split-page">
            <img src="{{ $a }}/images/bg.jpg" alt="永續發展">
            <div class="prose-page">
                <p class="eyebrow">Our commitment</p>
                <h3>用更好的材料與工法</h3>
                <p>泰權興以專業建構更美好的城市，並將環境友善、社會責任與綠色建築視為長期承諾，為下一代建構更永續的城市環境。</p>
                <div class="stats" style="margin-top:2rem">
                    <div>
                        <b>環境友善</b>
                        <small>降低碳排放、提升材料生命週期效率</small>
                    </div>
                    <div>
                        <b>社會責任</b>
                        <small>與在地工程夥伴共同提升施工安全與品質</small>
                    </div>
                    <div>
                        <b>綠色建築</b>
                        <small>導入低碳工法與綠建材，支援永續建築目標</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
