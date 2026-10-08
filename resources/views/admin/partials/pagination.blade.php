@if ($paginator->hasPages())
  <div class="pager">
    @if ($paginator->onFirstPage())
      <span class="btn ghost small" style="opacity:.45">‹ Sebelumnya</span>
    @else
      <a class="btn ghost small" href="{{ $paginator->previousPageUrl() }}">‹ Sebelumnya</a>
    @endif
    <span>Hal {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
    @if ($paginator->hasMorePages())
      <a class="btn ghost small" href="{{ $paginator->nextPageUrl() }}">Berikutnya ›</a>
    @else
      <span class="btn ghost small" style="opacity:.45">Berikutnya ›</span>
    @endif
  </div>
@endif
