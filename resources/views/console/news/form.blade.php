@extends('console.layout', ['title' => $item->exists ? '編輯消息' : '新增消息', 'heading' => $item->exists ? '編輯最新消息' : '新增最新消息'])

@section('content')
    <form class="console-form" method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('console.news.update', $item) : route('console.news.store') }}">
        @csrf
        @if ($item->exists)
            @method('PUT')
        @endif

        <label>
            <span>分類</span>
            <select name="news_category_id" required>
                <option value="">請選擇</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('news_category_id', $item->news_category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label>
            <span>標題</span>
            <input type="text" name="title" value="{{ old('title', $item->title) }}" required>
        </label>
        <label>
            <span>發布日期</span>
            <input type="date" name="published_on" value="{{ old('published_on', optional($item->published_on)->format('Y-m-d')) }}" required>
        </label>
        <label>
            <span>圖片{{ $item->exists ? '（可不選，沿用原圖）' : '' }}</span>
            <input type="file" name="image" accept="image/*" @required(! $item->exists)>
        </label>
        @if ($item->image)
            <img class="console-preview" src="{{ $item->imageUrl() }}" alt="">
        @endif
        <label>
            <span>外部連結</span>
            <input type="url" name="url" value="{{ old('url', $item->url) }}">
        </label>
        <label>
            <span>排序</span>
            <input type="number" name="sort" min="0" value="{{ old('sort', $item->sort) }}" required>
        </label>
        <div class="console-form__actions">
            <button type="submit">儲存</button>
            <a href="{{ route('console.news.index') }}">取消</a>
        </div>
    </form>
@endsection
