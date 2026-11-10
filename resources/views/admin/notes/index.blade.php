@extends('layouts.main')

@section('title', 'All Notes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">All Notes</h1>
        @if ($userId)
            <a href="{{ route('admin.notes') }}" class="btn btn-outline-secondary btn-sm">Clear user filter</a>
        @endif
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr><th>Title</th><th>Owner</th><th>Content</th><th>Created</th></tr>
                </thead>
                <tbody>
                    @forelse ($data as $note)
                        <tr>
                            <td><a href="{{ route('notes.show', $note['_id']) }}">{{ $note['title'] }}</a></td>
                            <td>
                                @if (is_array($note['user']))
                                    <a href="{{ route('admin.notes', ['userId' => $note['user']['_id']]) }}">{{ $note['user']['name'] }}</a>
                                @else
                                    <span class="text-muted">deleted user</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ \Illuminate\Support\Str::limit($note['content'], 80) }}</td>
                            <td class="text-muted small text-nowrap">{{ \Illuminate\Support\Carbon::parse($note['createdAt'])->toDateString() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">No notes found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('partials.pagination')
@endsection
