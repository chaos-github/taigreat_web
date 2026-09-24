{{-- 後台總覽：筆數、精選實績、最新消息 --}}
@extends('console.layout', ['title' => '總覽', 'heading' => '內容總覽'])

@section('content')
    <section class="console-stats">
        <a class="console-stat" href="{{ route('console.cases.index') }}">
            <small>工程實績</small>
            <strong>{{ $caseCount }}</strong>
            <span>前台精選 {{ $featuredCount }} 筆</span>
        </a>
        <a class="console-stat" href="{{ route('console.news.index') }}">
            <small>最新消息</small>
            <strong>{{ $newsCount }}</strong>
            <span>依發布日期顯示</span>
        </a>
        <a class="console-stat" href="{{ route('console.services.index') }}">
            <small>產品與服務</small>
            <strong>{{ $serviceCount }}</strong>
            <span>服務頁列表</span>
        </a>
    </section>

    <div class="console-grid">
        <section class="console-panel">
            <header>
                <h2>首頁精選實績</h2>
                <a href="{{ route('console.cases.index') }}">管理</a>
            </header>
            <ul class="console-plain-list">
                @forelse ($featuredCases as $case)
                    <li>
                        <span>{{ $case->title }}</span>
                        <small>{{ $case->category?->name }}</small>
                    </li>
                @empty
                    <li>尚未設定精選實績。</li>
                @endforelse
            </ul>
        </section>
        <section class="console-panel">
            <header>
                <h2>最新消息</h2>
                <a href="{{ route('console.news.index') }}">管理</a>
            </header>
            <ul class="console-plain-list">
                @forelse ($latestNews as $item)
                    <li>
                        <span>{{ $item->title }}</span>
                        <small>{{ $item->publishedLabel() }}</small>
                    </li>
                @empty
                    <li>目前沒有最新消息。</li>
                @endforelse
            </ul>
        </section>
    </div>
@endsection
