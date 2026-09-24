{{-- 最新消息列表 --}}
@extends('console.layout', ['title' => '最新消息', 'heading' => '最新消息管理'])

@section('content')
    <div class="console-toolbar">
        <div class="console-tabs">
            <a class="is-active" href="{{ route('console.news.index') }}">消息列表</a>
            <a href="{{ route('console.news-categories.index') }}">消息分類</a>
        </div>
        <a class="console-btn" href="{{ route('console.news.create') }}">新增消息</a>
    </div>

    <div class="console-table-wrap">
        <table class="console-table">
            <thead>
                <tr>
                    <th>圖片</th>
                    <th>標題</th>
                    <th>分類</th>
                    <th>發布日期</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($news as $item)
                    <tr>
                        <td><img class="console-thumb" src="{{ $item->imageUrl() }}" alt=""></td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->category?->name }}</td>
                        <td>{{ $item->publishedLabel() }}</td>
                        <td class="console-table__actions">
                            <a href="{{ route('console.news.edit', $item) }}">編輯</a>
                            <form method="post" action="{{ route('console.news.destroy', $item) }}" data-confirm="確定刪除這則消息？">
                                @csrf
                                @method('DELETE')
                                <button type="submit">刪除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">目前沒有最新消息。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $news->links('pagination.site') }}
@endsection
