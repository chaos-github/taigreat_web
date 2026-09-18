@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => '聯絡我們 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'images/contact_banner.jpg', 'heading' => '聯絡我們', 'en' => 'CONTACT US'])

    <section class="contact-top">
        <div class="contact-info">
            <p class="eyebrow" style="color:rgba(255,255,255,.7)">Taigreat</p>
            <h2>泰權興貿易</h2>
            <ul>
                <li>Email：<a href="mailto:info@taigreat.com.tw">info@taigreat.com.tw</a></li>
                <li>TEL：04-24220159</li>
                <li>406台中市北屯區昌平東二路156號</li>
            </ul>
        </div>
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29115.06492292904!2d120.67390019999998!3d24.19335825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34691779e1d3660b%3A0x2f0752da5ad44054!2z5oGG5bGV5aCC5bu656-J6IKh5Lu95pyJ6ZmQ5YWs5Y-4!5e0!3m2!1szh-TW!2stw!4v1788829631162!5m2!1szh-TW!2stw" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <section class="page-section">
        <div class="wrap">
            <p class="eyebrow">Message</p>
            <h2 style="font-size:1.8rem;font-weight:500;margin-bottom:1.5rem">聯絡資訊</h2>
            <p style="margin-bottom:1.8rem;color:#4b5560">感謝您光臨泰權興貿易，請留下您的聯絡資料與訊息，我們會儘快與您聯繫。</p>

            @if (session('status'))
                <div class="tw:mb-6 tw:bg-green-50 tw:px-5 tw:py-4 tw:text-green-800">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="tw:mb-6 tw:bg-red-50 tw:px-5 tw:py-4 tw:text-red-700">
                    <ul class="tw:m-0 tw:pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="site-form" method="post" action="{{ route('contact.send') }}">
                @csrf
                <div>
                    <label for="name">姓名</label>
                    <input id="name" name="name" type="text" required>
                </div>
                <div>
                    <label for="company">公司名稱</label>
                    <input id="company" name="company" type="text">
                </div>
                <div>
                    <label for="tel">聯絡電話</label>
                    <input id="tel" name="tel" type="text">
                </div>
                <div>
                    <label for="email">電子信箱</label>
                    <input id="email" name="email" type="email" required>
                </div>
                <div>
                    <label for="subject">主旨</label>
                    <input id="subject" name="subject" type="text" required>
                </div>
                <div>
                    <label for="content">留言訊息</label>
                    <textarea id="content" name="content" rows="5" required></textarea>
                </div>
                <div class="captcha-row">
                    <div style="flex:1">
                        <label for="captcha">驗證碼</label>
                        <input id="captcha" name="captcha" type="text" required>
                    </div>
                    <div>
                        <span class="captcha">{{ session('captcha_code', 'A7K2') }}</span>
                        <a href="{{ route('contact') }}" class="link-arrow" style="margin-left:0.6rem">換另一組</a>
                    </div>
                </div>
                <label class="check">
                    <input class="form-check-input" name="agree" type="checkbox" value="1" required>
                    <span>我同意資料保護條例和處理我的資料。您可以隨時撤銷此授權。</span>
                </label>
                <div class="form-actions">
                    <button type="submit">填好送出</button>
                </div>
            </form>
        </div>
    </section>
@endsection
