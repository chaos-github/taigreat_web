@extends('console.layout', ['title' => $caseItem->exists ? '編輯實績' : '新增實績', 'heading' => $caseItem->exists ? '編輯工程實績' : '新增工程實績'])

@section('content')
    <form class="console-form" method="post" enctype="multipart/form-data" action="{{ $caseItem->exists ? route('console.cases.update', $caseItem) : route('console.cases.store') }}">
        @csrf
        @if ($caseItem->exists)
            @method('PUT')
        @endif

        <label>
            <span>分類</span>
            <select name="case_category_id" required>
                <option value="">請選擇</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('case_category_id', $caseItem->case_category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </label>
        <label>
            <span>標題</span>
            <input type="text" name="title" value="{{ old('title', $caseItem->title) }}" required>
        </label>
        <label>
            <span>圖片{{ $caseItem->exists ? '（可不選，沿用原圖）' : '' }}</span>
            <input type="file" name="image" accept="image/*" @required(! $caseItem->exists)>
        </label>
        @if ($caseItem->image)
            <img class="console-preview" src="{{ $caseItem->imageUrl() }}" alt="">
        @endif
        <label class="console-check">
            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $caseItem->is_featured))>
            <span>顯示於首頁精選</span>
        </label>
        <label>
            <span>排序</span>
            <input type="number" name="sort" min="0" value="{{ old('sort', $caseItem->sort) }}" required>
        </label>
        <div class="console-form__actions">
            <button type="submit">儲存</button>
            <a href="{{ route('console.cases.index') }}">取消</a>
        </div>
    </form>
@endsection
