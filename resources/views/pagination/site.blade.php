@if ($paginator->hasPages())
    <nav class="pager" aria-label="分頁">
        @if ($paginator->onFirstPage())
            <span class="pager__disabled">上一頁</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">上一頁</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span>{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="is-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">下一頁</a>
        @else
            <span class="pager__disabled">下一頁</span>
        @endif
    </nav>
@endif
