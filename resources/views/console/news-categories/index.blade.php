@extends('console.layout', ['title' => '消息分類', 'heading' => '最新消息分類'])

@section('content')
    <div class="console-toolbar">
        <div class="console-tabs">
            <a href="{{ route('console.news.index') }}">消息列表</a>
            <a class="is-active" href="{{ route('console.news-categories.index') }}">消息分類</a>
        </div>
    </div>

    <div class="console-split">
        <form class="console-form" method="post" action="{{ $category->exists ? route('console.news-categories.update', $category) : route('console.news-categories.store') }}">
            @csrf
            @if ($category->exists)
                @method('PUT')
            @endif
            <h2>{{ $category->exists ? '編輯分類' : '新增分類' }}</h2>
            <label>
                <span>名稱</span>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
            </label>
            <label>
                <span>網址代碼</span>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required>
            </label>
            <label>
                <span>排序</span>
                <input type="number" name="sort" min="0" value="{{ old('sort', $category->sort) }}" required>
            </label>
            <div class="console-form__actions">
                <button type="submit">儲存</button>
                @if ($category->exists)
                    <a href="{{ route('console.news-categories.index') }}">取消編輯</a>
                @endif
            </div>
        </form>

        <div class="console-table-wrap">
            <table class="console-table">
                <thead>
                    <tr>
                        <th>名稱</th>
                        <th>代碼</th>
                        <th>筆數</th>
                        <th>排序</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->slug }}</td>
                            <td>{{ $item->news_count }}</td>
                            <td>{{ $item->sort }}</td>
                            <td class="console-table__actions">
                                <a href="{{ route('console.news-categories.edit', $item) }}">編輯</a>
                                <form method="post" action="{{ route('console.news-categories.destroy', $item) }}" data-confirm="確定刪除此分類？">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">刪除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
