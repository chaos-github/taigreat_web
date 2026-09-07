@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => 'CONTACT | 泰權興貿易'])

@section('header')
    @include('partials.page-banner', ['image' => 'images/contact_banner.jpg', 'heading' => '聯絡我們', 'en' => 'CONTACT US'])
@endsection

@section('content')
    <section class="n_bg">
        <div class="container-md">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="contact_box">
                        <img src="{{ $a }}/images/footer_logo.svg" class="img-fluid" alt="泰權興貿易">
                        <ul>
                            <li>Email : <a href="mailto:info@taigreat.com.tw">info@taigreat.com.tw</a></li>
                            <li>TEL : 04-24220159</li>
                            <li>406台中市北屯區昌平東二路156號</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29115.06492292904!2d120.67390019999998!3d24.19335825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x34691779e1d3660b%3A0x2f0752da5ad44054!2z5oGG5bGV5aCC5bu656-J6IKh5Lu95pyJ6ZmQ5YWs5Y-4!5e0!3m2!1szh-TW!2stw!4v1788829631162!5m2!1szh-TW!2stw" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="c_title"><h3>聯絡資訊</h3></div>
        <div class="c_bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <p>感謝您光臨泰權興貿易，請留下您的聯絡資料與訊息，我們會儘快與您聯繫。</p>
                    </div>
                    <div class="col-xxl-7 col-xl-8 col-lg-9">
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
                        <form method="post" action="{{ route('contact.send') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-3"><label>姓名</label></div>
                                <div class="col-lg-10 col-md-9 col-sm-9"><input name="name" type="text" class="form-control" required></div>
                                <div class="col-lg-2 col-md-3 col-sm-3"><label>公司名稱</label></div>
                                <div class="col-lg-10 col-md-9 col-sm-9"><input name="company" type="text" class="form-control"></div>
                                <div class="col-lg-2 col-md-3 col-sm-3"><label>聯絡電話</label></div>
                                <div class="col-lg-10 col-md-9 col-sm-9"><input name="tel" type="text" class="form-control"></div>
                                <div class="col-lg-2 col-md-3 col-sm-3"><label>電子信箱</label></div>
                                <div class="col-lg-10 col-md-9 col-sm-9"><input name="email" type="email" class="form-control" required></div>
                                <div class="col-lg-2 col-md-3 col-sm-3"><label>主旨</label></div>
                                <div class="col-lg-10 col-md-9 col-sm-9"><input name="subject" type="text" class="form-control" required></div>
                                <div class="col-lg-2 col-md-3 col-sm-3"><label>留言訊息</label></div>
                                <div class="col-lg-10 col-md-9 col-sm-9"><textarea name="content" rows="6" class="form-control" required></textarea></div>
                                <div class="col-lg-2 col-md-3 col-sm-3"><label>驗證碼</label></div>
                                <div class="col-lg-5 col-md-4 col-sm-4"><input name="captcha" type="text" class="form-control" required></div>
                                <div class="col-lg-5 col-md-5 col-sm-5">
                                    <div class="c_code">
                                        <span class="c_captcha">{{ session('captcha_code', 'A7K2') }}</span>
                                        <a href="{{ route('contact') }}" class="c_re">換另一組</a>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-3"></div>
                                <div class="col-lg-10 col-md-9 col-sm-9">
                                    <div class="form-check">
                                        <input class="form-check-input" name="agree" type="checkbox" value="1" id="checkagree" required>
                                        <label class="form-check-label" for="checkagree">我同意資料保護條例和處理我的資料。您可以隨時撤銷此授權。</label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit">填好送出</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
