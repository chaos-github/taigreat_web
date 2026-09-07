@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site')

@section('header')
    <div class="swiper index_swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <picture>
                    <source srcset="{{ $a }}/upload/adv/2407261159140000001.jpg" media="(max-width: 991px)">
                    <img src="{{ $a }}/upload/adv/2407261159140000001.jpg" width="100%" class="img-fluid" alt="專注建築材料及工法領域">
                </picture>
                <div class="in_b_title">
                    <h1>專注建築材料<br>及工法領域</h1>
                    <a href="{{ route('about') }}">了解更多</a>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
@endsection

@section('content')
    <section class="in_p_bg">
        <div class="container-fluid p-0">
            <div class="row gx-0 justify-content-between">
                <div class="col-lg-4">
                    <div class="in_p_title gs_reveal">
                        <h3>案例實績</h3>
                        <i></i>
                        <span>CASE</span>
                    </div>
                    <div class="in_p_box gs_reveal">
                        <a href="{{ route('case') }}">
                            <div class="in_p_img">
                                <img src="{{ $a }}/upload/product/2408081438400000001.jpg" class="img-fluid" alt="根基營造 泰山貴和安居 | RC | 台灣新北市">
                            </div>
                            <span>MFE 鋁合金系統模板</span>
                            <h3>根基營造 泰山貴和安居 | RC | 台灣新北市</h3>
                        </a>
                    </div>
                    <div class="in_p_box gs_reveal">
                        <a href="{{ route('case') }}">
                            <div class="in_p_img">
                                <img src="{{ $a }}/upload/product/2501071807320000001.jpg" class="img-fluid" alt="8 Conlay | RC | 馬來西亞 Kuala Lumpur">
                            </div>
                            <span>MFE 鋁合金系統模板</span>
                            <h3>8 Conlay | RC | 馬來西亞 Kuala Lumpur</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="in_p_box2 gs_reveal">
                        <a href="{{ route('case') }}">
                            <div class="in_p_img">
                                <img src="{{ $a }}/upload/product/2501082022490000001.JPG" class="img-fluid" alt="Cayan Tower | RC | Dubai杜拜">
                            </div>
                            <span>MFE 鋁合金系統模板</span>
                            <h3>Cayan Tower | RC | Dubai杜拜</h3>
                        </a>
                    </div>
                </div>
                <div class="col-lg-11">
                    <div class="in_p_a">
                        <a href="{{ route('case') }}">
                            了解更多
                            <div class="in_p_more">
                                @include('partials.dots')
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="in_bg_title">
            <p>
                <span>專業．誠信．創新</span>
                <span>專業．誠信．創新</span>
                <span>專業．誠信．創新</span>
            </p>
        </div>
    </section>

    <section class="in_s_bg bg5">
        <div class="in_s_img">
            <img src="{{ $a }}/images/bg.jpg" class="img-fluid in_s_pa" alt="圖">
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-8 offset-xl-1 col-lg-10">
                    <div class="row">
                        <div class="col-sm-7 order-1">
                            <div class="in_s_title gs_reveal">
                                <h3>服務項目</h3>
                                <i></i>
                                <span>OUR BUSINESS</span>
                            </div>
                        </div>
                        <div class="col-sm-5 order-3 order-sm-2">
                            <div class="in_s_a gs_reveal gs_reveal_fromRight">
                                <a href="{{ route('service') }}">
                                    了解更多
                                    <div class="in_s_more">@include('partials.dots')</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 order-2">
                            <div class="in_s_box">
                                <b>01</b>
                                <img src="{{ $a }}/images/s_1.jpg" class="img-fluid" alt="鋁合金系統模板">
                                <div class="in_s_box2"><h3>鋁合金系統模板</h3></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 order-2">
                            <div class="in_s_box gs_reveal">
                                <b>02</b>
                                <img src="{{ $a }}/images/s_2.jpg" class="img-fluid" alt="價值工程">
                                <div class="in_s_box2"><h3>價值工程</h3></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 order-2">
                            <div class="in_s_box gs_reveal">
                                <b>03</b>
                                <img src="{{ $a }}/images/s_3.jpg" class="img-fluid" alt="綠建築材料">
                                <div class="in_s_box2"><h3>綠建築材料</h3></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 order-2">
                            <div class="in_s_box gs_reveal">
                                <b>04</b>
                                <img src="{{ $a }}/images/s_4.jpg" class="img-fluid" alt="創新工法">
                                <div class="in_s_box2"><h3>創新工法</h3></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="in_n_bg bg5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="in_n_title gs_reveal">
                        <h3>最新消息</h3>
                        <i></i>
                        <span>RECENTLY NEWS</span>
                    </div>
                    <div class="relative gs_reveal">
                        <div class="swiper in_n_swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="in_n_items">
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
                        <div class="in_n_next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.622" height="42.157" viewBox="0 0 19.622 42.157"><path d="M14,5,31.813,25.02,14,45.039" transform="translate(-12.941 -3.941)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" /></svg>
                        </div>
                        <div class="in_n_prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.622" height="42.157" viewBox="0 0 19.622 42.157"><path d="M31.813,5,14,25.02l17.813,20.02" transform="translate(-13.25 -3.941)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" /></svg>
                        </div>
                    </div>
                    <div class="in_n_a gs_reveal">
                        <a href="{{ route('news') }}">了解更多</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="in_a_bg bg5" style="background-image: url({{ $a }}/images/bg2.jpg);">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 offset-lg-2 col-md-5">
                    <div class="in_a_img gs_reveal gs_reveal_fromLeft">
                        <img src="{{ $a }}/images/a_pic.jpg" class="img-fluid" alt="關於我們">
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 col-md-7">
                    <div class="in_a_box">
                        <div class="in_a_title gs_reveal">
                            <h3>關於我們</h3>
                            <i></i>
                            <span>ABOUT US</span>
                        </div>
                        <p class="gs_reveal">公司創立至今近四十年，持續在建築材料及創新工法上努力，引進海內外優質企業工藝技術並在台灣開發市場，針對台灣使用需求進行優化改良性質及成本控制。<br>我們目前有七大主要產品系列，並皆已獲得市場的肯定。</p>
                        <div class="in_a_a gs_reveal">
                            <a href="{{ route('about') }}">
                                了解更多
                                <div class="in_a_more">@include('partials.dots')</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="link_bg bg5 bgx-4" style="background-color: #e6e6e6;">
        <div class="relative gs_reveal">
            <div class="swiper in_link_swiper">
                <div class="swiper-wrapper">
                    @foreach ([
                        ['https://www.hahne.cn/', '2604291559000000001.png', '西偉德 悍能'],
                        ['https://www.tece.com/cn', '2604291508300000001.png', 'TECE'],
                        ['https://www.graphene.com.tw/home.php', '2501071842280000001.jpg', '石墨稀｜材料生產及應用'],
                        ['https://www.eternit.com.cn/', '2501071840320000001.jpg', '彩色水泥纖維板-埃特尼特板'],
                        ['http://easyto1098.com/', '2501071136300000001.jpg', '易塗｜斷熱稀土材料'],
                        ['https://www.cmimalaysia.com.my/about-us/', '2501071136580000001.jpg', '水泥複合材料'],
                        ['https://www.mfeformwork.com/', '2501071136070000001.jpg', '鋁合金系統模板'],
                    ] as $link)
                        <div class="swiper-slide">
                            <div class="in_n_items">
                                <a href="{{ $link[0] }}" target="_blank" rel="noopener">
                                    <img src="{{ $a }}/upload/link/{{ $link[1] }}" class="img-fluid" alt="{{ $link[2] }}">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="in_link_next">
                <svg xmlns="http://www.w3.org/2000/svg" width="19.622" height="42.157" viewBox="0 0 19.622 42.157"><path d="M14,5,31.813,25.02,14,45.039" transform="translate(-12.941 -3.941)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" /></svg>
            </div>
            <div class="in_link_prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="19.622" height="42.157" viewBox="0 0 19.622 42.157"><path d="M31.813,5,14,25.02l17.813,20.02" transform="translate(-13.25 -3.941)" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" /></svg>
            </div>
        </div>
    </section>

    <section class="bg5 in_c_bg" style="background-image: url({{ $a }}/images/bg3.jpg);">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-end">
                <div class="col-xxl-4 col-lg-5 col-md-6">
                    <div class="in_s_title in_c_title gs_reveal">
                        <h3>聯絡我們</h3>
                        <i></i>
                        <span>CONTACT US</span>
                    </div>
                    <div class="in_c_box">
                        <p>如有任何問題，<br>請通過電話或查詢表格與我們聯繫。</p>
                    </div>
                </div>
                <div class="col-xxl-3 col-lg-5 col-md-6">
                    <div class="in_c_box2">
                        <h4>TEL. 04-24220159</h4>
                        <a href="{{ route('contact') }}">
                            <span>與我們聯絡</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="26.306" height="26.306" viewBox="0 0 26.306 26.306">
                                <g transform="translate(-1354 -5733)">
                                    <g transform="translate(1354 5733)" fill="currentColor" stroke="currentColor" stroke-width="1">
                                        <circle cx="13.153" cy="13.153" r="13.153" stroke="none" />
                                        <circle cx="13.153" cy="13.153" r="12.653" fill="none" />
                                    </g>
                                    <g transform="translate(1361.445 5743.423)">
                                        <path d="M14,5l2.875,2.875L14,10.751" transform="translate(-4.963 -5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                        <line x1="7.135" transform="translate(1.784 2.875)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                    </g>
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    new Swiper('.in_n_swiper', {
        slidesPerView: 1,
        spaceBetween: 40,
        loop: true,
        navigation: { nextEl: '.in_n_next', prevEl: '.in_n_prev' },
        breakpoints: { 767: { slidesPerView: 2 }, 1240: { slidesPerView: 3 } },
    });
    new Swiper('.in_link_swiper', {
        slidesPerView: 1,
        spaceBetween: 40,
        loop: true,
        navigation: { nextEl: '.in_link_next', prevEl: '.in_link_prev' },
        breakpoints: { 767: { slidesPerView: 2 }, 1199: { slidesPerView: 3 }, 1240: { slidesPerView: 5 } },
    });
</script>
@endpush
