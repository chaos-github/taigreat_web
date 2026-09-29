{{-- 關於我們 / 永續發展後台編輯 --}}
@extends('console.layout', [
    'title' => $page->heading,
    'heading' => '編輯'.$page->heading,
])

@section('content')
    <form class="console-form" method="post" enctype="multipart/form-data" action="{{ route('console.'.$page->slug.'.update') }}">
        @csrf
        @method('PUT')

        <label>
            <span>頁面標題</span>
            <input type="text" name="heading" value="{{ old('heading', $page->heading) }}" required>
        </label>
        <label>
            <span>英文標題</span>
            <input type="text" name="heading_en" value="{{ old('heading_en', $page->heading_en) }}" required>
        </label>
        <label>
            <span>橫幅圖片（可不選，沿用原圖）</span>
            <input type="file" name="banner_image" accept="image/*">
        </label>
        @if ($page->banner_image)
            <img class="console-preview" src="{{ $page->bannerUrl() }}" alt="">
        @endif
        <label>
            <span>內文圖片（可不選，沿用原圖）</span>
            <input type="file" name="image" accept="image/*">
        </label>
        @if ($page->image)
            <img class="console-preview" src="{{ $page->imageUrl() }}" alt="">
        @endif
        <label>
            <span>小標</span>
            <input type="text" name="eyebrow" value="{{ old('eyebrow', $page->eyebrow) }}" required>
        </label>
        <label>
            <span>區塊標題</span>
            <input type="text" name="subtitle" value="{{ old('subtitle', $page->subtitle) }}" required>
        </label>
        @if ($page->slug === 'about')
            <label>
                <span>引言</span>
                <textarea name="lead" rows="4" required>{{ old('lead', $page->lead) }}</textarea>
            </label>
        @endif
        <label>
            <span>內文</span>
            <textarea name="body" rows="5" required>{{ old('body', $page->body) }}</textarea>
        </label>

        @if ($page->slug === 'about')
            <fieldset class="console-links">
                <legend>使命</legend>
                <label>
                    <span>小標</span>
                    <input type="text" name="mission_eyebrow" value="{{ old('mission_eyebrow', $page->extraValue('mission_eyebrow')) }}" required>
                </label>
                <label>
                    <span>標題</span>
                    <input type="text" name="mission_title" value="{{ old('mission_title', $page->extraValue('mission_title')) }}" required>
                </label>
                <label>
                    <span>內文</span>
                    <textarea name="mission_body" rows="3" required>{{ old('mission_body', $page->extraValue('mission_body')) }}</textarea>
                </label>
                <label>
                    <span>英文（Enter 換行）</span>
                    <textarea name="mission_en" rows="3" required>{{ old('mission_en', $page->extraValue('mission_en')) }}</textarea>
                </label>
            </fieldset>
        @else
            <fieldset class="console-links">
                <legend>重點項目</legend>
                @foreach (old('stats', $page->stats()) as $index => $stat)
                    <div class="console-stat-row">
                        <input type="text" name="stats[{{ $index }}][title]" value="{{ $stat['title'] ?? '' }}" placeholder="標題" required>
                        <input type="text" name="stats[{{ $index }}][text]" value="{{ $stat['text'] ?? '' }}" placeholder="說明" required>
                    </div>
                @endforeach
            </fieldset>
        @endif

        <div class="console-form__actions">
            <button type="submit">儲存</button>
            <a href="{{ route($page->slug) }}" target="_blank" rel="noopener">查看前台</a>
        </div>
    </form>
@endsection
