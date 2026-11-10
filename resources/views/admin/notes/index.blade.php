@extends('layouts.main')

@section('title', 'All Notes')

@section('content')
    <h1>All Notes</h1>
    @if ($userId)
        <p>Filtered by user. <a href="{{ route('admin.notes') }}">Show all</a></p>
    @endif

    <table>
        <thead>
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
                            <span class="muted">deleted user</span>
                        @endif
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($note['content'], 80) }}</td>
                    <td class="muted">{{ \Illuminate\Support\Carbon::parse($note['createdAt'])->toDateString() }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No notes found.</td></tr>
            @endforelse
        </tbody>
    </table>

    @include('partials.pagination')
@endsection
