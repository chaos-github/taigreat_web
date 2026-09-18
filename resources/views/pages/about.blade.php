@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => '關於我們 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261545110000001.jpg', 'heading' => '關於我們', 'en' => 'ABOUT US'])

    <section class="page-section">
        <div class="wrap split-page">
            <img src="{{ $a }}/images/pic_4.jpg" alt="公司簡介">
            <div class="prose-page">
                <p class="eyebrow">Company</p>
                <h3>公司簡介</h3>
                <h4>公司創立至今近四十年，持續在建築材料及創新工法上努力，引進海內外優質企業工藝技術並在台灣開發市場，針對台灣使用需求進行優化改良性質及成本控制。</h4>
                <p>我們目前有七大主要產品系列，並皆已獲得市場的肯定。</p>
            </div>
        </div>
        <div class="wrap">
            <div class="mission">
                <p class="eyebrow">Mission</p>
                <h3>使命</h3>
                <p>創新成就品質工程、工法推動建築發展</p>
                <p>【Innovation drives quality engineering】<br>【Advanced techniques propel architectural progress】</p>
            </div>
        </div>
    </section>
@endsection
