@php
    $a = asset('assets/taigreat');
@endphp
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '泰權興貿易' }}</title>
    <link rel="icon" href="{{ $a }}/images/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Jost:wght@400;500&family=Noto+Sans+TC:wght@100;300;400;500&display=swap" rel="stylesheet">
    <link href="{{ $a }}/css/bootstrap-grid.min.css" rel="stylesheet">
    <link href="{{ $a }}/css/swiper-bundle.min.css" rel="stylesheet">
    <link href="{{ $a }}/css/style.min.css" rel="stylesheet">
    <link href="{{ $a }}/css/animate.css" rel="stylesheet">
    <link href="{{ $a }}/css/extras.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<header>
    <nav class="navbar-default">
        <div class="nav_right">
            <a href="{{ route('home') }}">
                <img src="{{ $a }}/images/logo.svg" class="img-fluid" alt="泰權興貿易">
            </a>
        </div>
        <div class="nav_box">
            <dl>
                <dd><a href="{{ route('about') }}">關於泰權興</a></dd>
                <dd><a href="{{ route('news') }}">最新消息</a></dd>
                <dd><a href="{{ route('case') }}">案例實績</a></dd>
                <dd><a href="{{ route('service') }}">服務項目</a></dd>
            </dl>
            <div class="kcce_link">
                <a href="{{ route('contact') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22.662" height="17.626" viewBox="0 0 22.662 17.626">
                        <path d="M122.034-742.374a1.97,1.97,0,0,1-1.452-.582,1.97,1.97,0,0,1-.582-1.452v-13.558a1.97,1.97,0,0,1,.582-1.452,1.97,1.97,0,0,1,1.452-.582h18.594a1.97,1.97,0,0,1,1.452.582,1.97,1.97,0,0,1,.582,1.452v13.558a1.97,1.97,0,0,1-.582,1.452,1.97,1.97,0,0,1-1.452.582Zm9.3-8.668-10.072-6.586v13.22a.755.755,0,0,0,.218.557.755.755,0,0,0,.557.218h18.594a.755.755,0,0,0,.557-.218.755.755,0,0,0,.218-.557v-13.22Zm0-1.4,9.685-6.3H121.646Zm-10.072-5.181v13.22a.755.755,0,0,0,.218.557.755.755,0,0,0,.557.218h-.775Z" transform="translate(-120 760)" fill="#fff" />
                    </svg>
                    <span>聯絡我們</span>
                </a>
            </div>
            <div class="togglebar">
                <i></i><i></i><i></i>
            </div>
        </div>
    </nav>
    @yield('header')
</header>

<div class="wrapper">
    @yield('content')

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="tw:flex tw:flex-wrap tw:items-center tw:justify-center">
                        <img src="{{ $a }}/images/footer_logo.svg" class="img-fluid tw:mx-3 tw:mb-3" alt="泰權興貿易">
                        <img src="{{ $a }}/images/footer_logo3.svg" class="img-fluid tw:mx-3 tw:mb-3" alt="圖">
                    </div>
                    <ul>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="9.2" height="19.2" viewBox="0 0 9.2 19.2">
                                <g transform="translate(-665.4 -5884.96)">
                                    <path d="M15.93,18.64A.92.92,0,0,1,16,19c0,1.1-1.79,2-4,2s-4-.9-4-2a.92.92,0,0,1,.07-.36M9,6a3,3,0,0,0,3,3h0a3,3,0,0,0,3-3h0a3,3,0,0,0-3-3h0A3,3,0,0,0,9,6Zm3,3v8" transform="translate(658 5882.56)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                </g>
                            </svg>
                            406台中市北屯區昌平東二路156號
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.201" height="19.2" viewBox="0 0 19.201 19.2">
                                <g transform="translate(-986.4 -5884.96)">
                                    <path d="M12.55,14.63,19.45,10a1,1,0,0,1,1.55.83V20a1,1,0,0,1-1,1H4a1,1,0,0,1-1-1V10.87A1,1,0,0,1,4.55,10l6.9,4.59a1,1,0,0,0,1.1.04Zm-1.1,0a1,1,0,0,0,1.1,0L18,11V4a1,1,0,0,0-1-1H8L6,5v6ZM6,5H8V3Z" transform="translate(984.001 5882.56)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                </g>
                            </svg>
                            <a href="mailto:info@taigreat.com.tw">info@taigreat.com.tw</a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.085" height="19.155" viewBox="0 0 19.085 19.155">
                                <g transform="translate(-1251.396 -5884.96)">
                                    <path d="M21,15v3.93a2,2,0,0,1-2.29,2A18,18,0,0,1,3.14,5.29,2,2,0,0,1,5.13,3H9a1,1,0,0,1,1,.89,10.74,10.74,0,0,0,1,3.78,1,1,0,0,1-.42,1.26l-.86.49a1,1,0,0,0-.33,1.46,14.08,14.08,0,0,0,3.69,3.69,1,1,0,0,0,1.46-.33l.49-.86a1,1,0,0,1,1.3-.38,10.74,10.74,0,0,0,3.78,1A1,1,0,0,1,21,15Z" transform="translate(1248.881 5882.56)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                </g>
                            </svg>
                            04-24220159
                        </li>
                    </ul>
                    <dl>
                        <dt>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.2" height="19.2" viewBox="0 0 19.2 19.2">
                                <g transform="translate(-910.4 -5931.46)">
                                    <g transform="translate(908 5929.06)">
                                        <circle cx="3" cy="3" r="3" transform="translate(3 9)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                        <circle cx="3" cy="3" r="3" transform="translate(15 15)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                        <line x2="6.62" y2="3.31" transform="translate(8.68 13.34)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                        <circle cx="3" cy="3" r="3" transform="translate(15 3)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                        <line y1="3.31" x2="6.62" transform="translate(8.68 7.35)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" />
                                    </g>
                                </g>
                            </svg>
                            FOLLOW US
                        </dt>
                        <dd>
                            <a href="https://www.facebook.com/profile.php?id=61584832558218&locale=zh_TW" title="facebook" target="_blank" rel="noopener">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17.675" height="17.675" viewBox="0 0 17.675 17.675">
                                    <path d="M17.673,8.891A8.838,8.838,0,1,0,7.454,17.674V11.461H5.211V8.892H7.456V6.931a3.128,3.128,0,0,1,3.338-3.458,13.516,13.516,0,0,1,1.978.173V5.833H11.658a1.281,1.281,0,0,0-1.439,1.39V8.891h2.45l-.391,2.569h-2.06v6.213A8.877,8.877,0,0,0,17.673,8.891Z" fill="#fff" />
                                </svg>
                            </a>
                        </dd>
                    </dl>
                    <p>Copyright © 2024 泰權興貿易 All Rights Reserved.<a href="https://www.artware.com.tw/" title="艾傑網頁設計公司 網頁設計" target="_blank" rel="noopener">Design by ARTWARE</a></p>
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/ScrollTrigger.min.js"></script>
<script>
    $('.togglebar').click(function () {
        $('.nav_box dl').toggleClass('active');
        $(this).toggleClass('active');
    });
    var scrollDown = 0;
    $(window).scroll(function () {
        var up = $(this).scrollTop();
        if (up > scrollDown) {
            $('.navbar-default').removeClass('active');
        } else {
            $('.navbar-default').addClass('active');
        }
        scrollDown = up;
        if ($(window).scrollTop() >= 100) {
            $('.navbar-default').addClass('hide');
        } else {
            $('.navbar-default').removeClass('hide');
        }
    });
</script>
<script src="{{ $a }}/js/myscript.js"></script>
@stack('scripts')
</body>
</html>
