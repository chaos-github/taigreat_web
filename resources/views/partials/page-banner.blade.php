@php $a = asset('assets/taigreat'); @endphp
<div class="about_banner" style="background-image: url({{ $a }}/{{ $image }});">
    <div class="a_title">
        <h1>{{ $heading }}</h1>
        <span>{{ $en }}</span>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="bread_box">
                <ul>
                    <li><a href="{{ route('home') }}">首頁</a></li>
                    <li><i></i></li>
                    <li>{{ $heading }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
