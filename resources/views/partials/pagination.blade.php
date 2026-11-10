@if (($meta['totalPages'] ?? 0) > 1)
    <div class="pagination">
        @if ($meta['page'] > 1)
            <a href="{{ request()->fullUrlWithQuery(['page' => $meta['page'] - 1]) }}">&laquo; Previous</a>
        @endif
        <span class="muted">Page {{ $meta['page'] }} of {{ $meta['totalPages'] }} ({{ $meta['total'] }} total)</span>
        @if ($meta['page'] < $meta['totalPages'])
            <a href="{{ request()->fullUrlWithQuery(['page' => $meta['page'] + 1]) }}">Next &raquo;</a>
        @endif
    </div>
@endif
