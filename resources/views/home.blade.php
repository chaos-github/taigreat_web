@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site')

@section('content')
    <section class="hero">
        <div class="hero__copy">
            <p class="eyebrow">Build a better tomorrow</p>
            <h1>以專業建構<br>更美好的城市</h1>
            <p>泰權興專注於建築材料與工法，提供高品質整合性系統模板與創新建築解決方案，與您一起打造更安全、更高效率、更永續的建築未來。</p>
            <a class="btn" href="{{ route('about') }}">探索我們的優勢 →</a>
            <div class="hero__meta">01　—　02　—　03</div>
        </div>
        <div class="hero__visual">
            <img src="{{ $a }}/upload/adv/2407261159140000001.jpg" alt="以專業建構更美好的城市">
            <div class="hero__badge">
                <b>TAIGREAT</b>
                <span>PEOPLE<br>MATERIAL<br>TECHNOLOGY<br>A BETTER CITY</span>
            </div>
        </div>
    </section>

    <section class="about-block">
        <div class="wrap about-grid">
            <div>
                <p class="eyebrow">About Taigreat</p>
                <h2>關於泰權興</h2>
                <p>泰權興貿易有限公司專注於建築材料與工法，以專業的技術與服務，提供客戶高效率、高品質的解決方案，持續為城市建設創造價值。</p>
                <div class="stats">
                    <div>
                        <b>40+</b>
                        <small>年產業經驗　YEARS OF EXPERIENCE</small>
                    </div>
                    <div>
                        <b>300+</b>
                        <small>完成專案　PROJECTS COMPLETED</small>
                    </div>
                    <div>
                        <b>100%</b>
                        <small>客戶滿意度　CUSTOMER SATISFACTION</small>
                    </div>
                </div>
                <a class="link-arrow" href="{{ route('about') }}">深入了解我們 →</a>
            </div>
            <div class="about-photo">
                <img src="{{ $a }}/images/a_pic.jpg" alt="關於泰權興">
                <em>BUILD<br>BETTER<br>LIVE<br>GREENER</em>
            </div>
        </div>
    </section>

    <section class="band band-paper">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Our business</p>
                    <h2>產品與服務</h2>
                    <p class="section-kicker">整合產品、技術與服務，提供全方位的建築解決方案。</p>
                </div>
                <a class="link-arrow" href="{{ route('service') }}">探索更多服務 →</a>
            </div>
            <div class="card-grid">
                @foreach ([
                    ['s_1.jpg', '鋁合金系統模板', '輕量化、高精度、高效率'],
                    ['s_2.jpg', '價值工程', '專業評估、成本優化、產能增值'],
                    ['s_3.jpg', '綠建築材料', '環保永續、性能節能、健康生活'],
                    ['s_4.jpg', '創新工法', '持續研發、提升效率、創造可能'],
                ] as $item)
                    <a class="photo-card" href="{{ route('service') }}">
                        <img src="{{ $a }}/images/{{ $item[0] }}" alt="{{ $item[1] }}">
                        <h3>{{ $item[1] }}</h3>
                        <p>{{ $item[2] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="band">
        <div class="wrap">
            <div class="section-head">
                <div>
                    <p class="eyebrow">Featured projects</p>
                    <h2>工程實績</h2>
                </div>
                <a class="link-arrow" href="{{ route('case') }}">查看更多實績 →</a>
            </div>
            <div class="project-grid">
                @forelse ($featuredCases as $case)
                    <a class="project-card" href="{{ route('case') }}">
                        <img src="{{ $case->imageUrl() }}" alt="{{ $case->title }}">
                        <h3>{{ $case->title }}</h3>
                        <span>{{ $case->category->name }}</span>
                    </a>
                @empty
                    <p>目前沒有精選實績。</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="sustain">
        <div class="sustain__media">
            <img src="{{ $a }}/images/bg.jpg" alt="永續發展">
            <div class="sustain__copy">
                <p class="eyebrow" style="color:rgba(255,255,255,.8)">Sustainability</p>
                <h2>永續發展</h2>
                <p>用更好的材料與工法，為下一代建構更永續的城市環境。</p>
                <a class="btn btn-light" href="{{ route('sustainability') }}" style="margin-top:1.2rem">了解我們的永續行動 →</a>
            </div>
        </div>
        <div class="sustain__side">
            <div class="sustain-item">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.4"><circle cx="12" cy="12" r="9"/><path d="M8 12h8M12 8v8"/></svg>
                <div>
                    <h3>環境友善</h3>
                    <p>ENVIRONMENT</p>
                </div>
            </div>
            <div class="sustain-item">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.4"><circle cx="9" cy="8" r="3"/><circle cx="16" cy="9" r="2.5"/><path d="M4 19c.8-3 3-5 5-5s4.2 2 5 5M13 19c.4-2 1.6-3.5 3-3.5 1.6 0 2.8 1.4 3.2 3.5"/></svg>
                <div>
                    <h3>社會責任</h3>
                    <p>SOCIAL</p>
                </div>
            </div>
            <div class="sustain-item">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.4"><path d="M4 20V10l8-6 8 6v10"/><path d="M10 20v-6h4v6"/></svg>
                <div>
                    <h3>綠色建築</h3>
                    <p>GREEN BUILDING</p>
                </div>
            </div>
            <p class="quote">SMALL<br>CHANGES<br>MAKE A<br>GREATER<br>TOMORROW</p>
        </div>
    </section>

    <section class="split">
        <div class="news-block">
            <div class="wrap">
                <div class="section-head">
                    <div>
                        <p class="eyebrow">Latest news</p>
                        <h2>最新消息</h2>
                    </div>
                    <a class="link-arrow" href="{{ route('news') }}">查看更多 →</a>
                </div>
                <div class="news-grid">
                    <a class="news-card" href="https://money.udn.com/money/story/5721/8421484" target="_blank" rel="noopener">
                        <img src="{{ $a }}/upload/news/2501061753420000001.jpg" alt="建材展-MFE 鋁合金系統模板台灣獨家代理">
                        <time>2024.12.20</time>
                        <h3>泰權興參與台中大型住宅工程　鋁合金模板助攻工期</h3>
                    </a>
                    <a class="news-card" href="{{ route('news') }}">
                        <img src="{{ $a }}/images/s_3.jpg" alt="綠建築材料動態">
                        <time>2025.03.18</time>
                        <h3>綠建築、低碳材料動態更新　持續與產業夥伴合作</h3>
                    </a>
                </div>
            </div>
        </div>
        <aside class="contact-cta">
            <img src="{{ $a }}/images/bg3.jpg" alt="聯絡我們">
            <div class="contact-cta__inner">
                <p class="eyebrow" style="color:rgba(255,255,255,.75)">Contact us</p>
                <h2>聯絡我們</h2>
                <p>與我們一起討論您的下一個專案，提供最專業的解決方案。</p>
                <a class="btn btn-light" href="{{ route('contact') }}" style="margin-top:1.3rem">立即聯絡我們 →</a>
            </div>
        </aside>
    </section>
@endsection
