@if ($paginator->hasPages())
    <nav class="pager" aria-label="Halaman">
        @if ($paginator->onFirstPage())
            <span class="btn btn-outline btn-sm is-disabled">&larr; Sebelumnya</span>
        @else
            <a class="btn btn-outline btn-sm" href="{{ $paginator->previousPageUrl() }}" rel="prev">&larr; Sebelumnya</a>
        @endif

        <span class="muted small">Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a class="btn btn-outline btn-sm" href="{{ $paginator->nextPageUrl() }}" rel="next">Berikutnya &rarr;</a>
        @else
            <span class="btn btn-outline btn-sm is-disabled">Berikutnya &rarr;</span>
        @endif
    </nav>
@endif
