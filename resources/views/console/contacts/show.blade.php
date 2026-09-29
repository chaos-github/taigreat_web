{{-- 前台聯絡我們留言詳情 --}}
@extends('console.layout', ['title' => '留言詳情', 'heading' => '留言詳情'])

@section('content')
    <div class="console-toolbar">
        <a class="console-btn console-btn--ghost" href="{{ route('console.contacts.index') }}">返回列表</a>
        <form method="post" action="{{ route('console.contacts.destroy', $contact) }}" data-confirm="確定刪除這則留言？">
            @csrf
            @method('DELETE')
            <button class="console-btn console-btn--danger" type="submit">刪除留言</button>
        </form>
    </div>

    <dl class="console-detail">
        <div>
            <dt>送出時間</dt>
            <dd>{{ $contact->created_at->format('Y.m.d H:i') }}</dd>
        </div>
        <div>
            <dt>姓名</dt>
            <dd>{{ $contact->name }}</dd>
        </div>
        <div>
            <dt>公司名稱</dt>
            <dd>{{ $contact->company !== null && $contact->company !== '' ? $contact->company : '—' }}</dd>
        </div>
        <div>
            <dt>聯絡電話</dt>
            <dd>{{ $contact->tel !== null && $contact->tel !== '' ? $contact->tel : '—' }}</dd>
        </div>
        <div>
            <dt>電子信箱</dt>
            <dd><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></dd>
        </div>
        <div>
            <dt>主旨</dt>
            <dd>{{ $contact->subject }}</dd>
        </div>
        <div>
            <dt>留言訊息</dt>
            <dd class="console-detail__body">{{ $contact->safeContent() }}</dd>
        </div>
    </dl>
@endsection
