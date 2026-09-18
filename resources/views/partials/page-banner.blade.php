@php $a = asset('assets/taigreat'); @endphp
<section class="page-hero" @if (! empty($image)) style="background-image: linear-gradient(rgba(12,34,51,.45), rgba(12,34,51,.55)), url({{ $a }}/{{ $image }})" @endif>
    <div class="wrap">
        <p class="eyebrow" style="color:rgba(255,255,255,.75)">{{ $en }}</p>
        <h1>{{ $heading }}</h1>
    </div>
</section>
<nav class="crumb wrap" aria-label="麵包屑">
    <a href="{{ route('home') }}">首頁</a>
    &nbsp;/&nbsp;
    <span>{{ $heading }}</span>
</nav>
