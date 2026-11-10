@if (($meta['totalPages'] ?? 0) > 1)
    <nav class="d-flex justify-content-between align-items-center mt-3">
        <small class="text-muted">Page {{ $meta['page'] }} of {{ $meta['totalPages'] }} &middot; {{ $meta['total'] }} total</small>
        <ul class="pagination pagination-sm mb-0">
            <li class="page-item @if ($meta['page'] <= 1) disabled @endif">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $meta['page'] - 1]) }}">Previous</a>
            </li>
            <li class="page-item @if ($meta['page'] >= $meta['totalPages']) disabled @endif">
                <a class="page-link" href="{{ request()->fullUrlWithQuery(['page' => $meta['page'] + 1]) }}">Next</a>
            </li>
        </ul>
    </nav>
@endif
