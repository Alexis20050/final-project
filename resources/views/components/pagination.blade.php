@if ($paginator->hasPages())
    <div class="pagination-bar">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page-item disabled">← Prev</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-item">← Prev</a>
        @endif

        {{-- Page numbers – all of them (simple & reliable) --}}
        @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
            @if ($page == $paginator->currentPage())
                <span class="page-item active">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="page-item">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-item">Next →</a>
        @else
            <span class="page-item disabled">Next →</span>
        @endif
    </div>
@endif