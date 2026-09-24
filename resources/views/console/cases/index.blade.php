@extends('console.layout', ['title' => '工程實績', 'heading' => '工程實績管理'])

@section('content')
    <div class="console-toolbar">
        <div class="console-tabs">
            <a class="is-active" href="{{ route('console.cases.index') }}">實績列表</a>
            <a href="{{ route('console.case-categories.index') }}">實績分類</a>
        </div>
        <a class="console-btn" href="{{ route('console.cases.create') }}">新增實績</a>
    </div>

    <div class="console-table-wrap">
        <table class="console-table">
            <thead>
                <tr>
                    <th>圖片</th>
                    <th>標題</th>
                    <th>分類</th>
                    <th>精選</th>
                    <th>排序</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cases as $case)
                    <tr>
                        <td><img class="console-thumb" src="{{ $case->imageUrl() }}" alt=""></td>
                        <td>{{ $case->title }}</td>
                        <td>{{ $case->category?->name }}</td>
                        <td>{{ $case->is_featured ? '是' : '否' }}</td>
                        <td>{{ $case->sort }}</td>
                        <td class="console-table__actions">
                            <a href="{{ route('console.cases.edit', $case) }}">編輯</a>
                            <form method="post" action="{{ route('console.cases.destroy', $case) }}" data-confirm="確定刪除這筆工程實績？">
                                @csrf
                                @method('DELETE')
                                <button type="submit">刪除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">目前沒有工程實績。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $cases->links('pagination.site') }}
@endsection
