@extends('console.layout', ['title' => '產品與服務', 'heading' => '產品與服務管理'])

@section('content')
    <div class="console-toolbar">
        <p class="console-toolbar__note">這裡的內容會顯示在官網「產品與服務」頁。</p>
        <a class="console-btn" href="{{ route('console.services.create') }}">新增服務</a>
    </div>

    <div class="console-table-wrap">
        <table class="console-table">
            <thead>
                <tr>
                    <th>圖片</th>
                    <th>編號</th>
                    <th>標題</th>
                    <th>排序</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td><img class="console-thumb" src="{{ $service->imageUrl() }}" alt=""></td>
                        <td>{{ $service->number }}</td>
                        <td>{{ $service->title }}</td>
                        <td>{{ $service->sort }}</td>
                        <td class="console-table__actions">
                            <a href="{{ route('console.services.edit', $service) }}">編輯</a>
                            <form method="post" action="{{ route('console.services.destroy', $service) }}" data-confirm="確定刪除此服務項目？">
                                @csrf
                                @method('DELETE')
                                <button type="submit">刪除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">目前沒有產品與服務。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $services->links('pagination.site') }}
@endsection
