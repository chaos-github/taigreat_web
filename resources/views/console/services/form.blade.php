{{-- 產品與服務新增 / 編輯；說明欄是 textarea，Enter 會存成換行 --}}
@extends('console.layout', ['title' => $service->exists ? '編輯服務' : '新增服務', 'heading' => $service->exists ? '編輯產品與服務' : '新增產品與服務'])

@section('content')
    <form class="console-form" method="post" enctype="multipart/form-data" action="{{ $service->exists ? route('console.services.update', $service) : route('console.services.store') }}">
        @csrf
        @if ($service->exists)
            @method('PUT')
        @endif

        <label>
            <span>編號</span>
            <input type="text" name="number" value="{{ old('number', $service->number) }}" required>
        </label>
        <label>
            <span>標題</span>
            <input type="text" name="title" value="{{ old('title', $service->title) }}" required>
        </label>
        <label>
            <span>說明</span>
            <textarea name="description" rows="6" required>{{ old('description', $service->description) }}</textarea>
        </label>
        <label>
            <span>圖片{{ $service->exists ? '（可不選，沿用原圖）' : '' }}</span>
            <input type="file" name="image" accept="image/*" @required(! $service->exists)>
        </label>
        @if ($service->image)
            <img class="console-preview" src="{{ $service->imageUrl() }}" alt="">
        @endif

        <fieldset class="console-links" data-link-list>
            <legend>相關連結</legend>
            @foreach (old('links', $service->links ?? [['url' => '', 'label' => '']]) as $index => $link)
                <div class="console-link-row">
                    <input type="url" name="links[{{ $index }}][url]" value="{{ $link['url'] ?? '' }}" placeholder="https://">
                    <input type="text" name="links[{{ $index }}][label]" value="{{ $link['label'] ?? '' }}" placeholder="顯示文字">
                    <button type="button" data-remove-link>移除</button>
                </div>
            @endforeach
            <button type="button" class="console-btn console-btn--ghost" data-add-link>新增連結</button>
        </fieldset>

        <label>
            <span>排序</span>
            <input type="number" name="sort" min="0" value="{{ old('sort', $service->sort) }}" required>
        </label>
        <div class="console-form__actions">
            <button type="submit">儲存</button>
            <a href="{{ route('console.services.index') }}">取消</a>
        </div>
    </form>
@endsection
