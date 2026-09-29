{{-- 前台聯絡我們留言列表 --}}
@extends('console.layout', ['title' => '聯絡我們', 'heading' => '聯絡我們留言'])

@section('content')
    <div class="console-toolbar">
        <p class="console-toolbar__note">前台表單送出的內容會出現在這裡。</p>
    </div>

    <div class="console-table-wrap">
        <table class="console-table">
            <thead>
                <tr>
                    <th>時間</th>
                    <th>姓名</th>
                    <th>主旨</th>
                    <th>電子信箱</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr>
                        <td>{{ $contact->created_at->format('Y.m.d H:i') }}</td>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->subject }}</td>
                        <td>{{ $contact->email }}</td>
                        <td class="console-table__actions">
                            <a href="{{ route('console.contacts.show', $contact) }}">查看</a>
                            <form method="post" action="{{ route('console.contacts.destroy', $contact) }}" data-confirm="確定刪除這則留言？">
                                @csrf
                                @method('DELETE')
                                <button type="submit">刪除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">目前沒有留言。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $contacts->links('pagination.site') }}
@endsection
