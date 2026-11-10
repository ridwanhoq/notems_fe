@extends('layouts.main')

@section('title', 'My Notes')

@section('content')
    <h1>My Notes</h1>
    <p><a href="{{ route('notes.create') }}">+ New note</a></p>

    @forelse ($data as $note)
        <div class="card">
            <strong><a href="{{ route('notes.show', $note['_id']) }}">{{ $note['title'] }}</a></strong>
            <div class="muted">Updated {{ \Illuminate\Support\Carbon::parse($note['updatedAt'])->diffForHumans() }}</div>
            <p>{{ \Illuminate\Support\Str::limit($note['content'], 200) }}</p>
            <a href="{{ route('notes.edit', $note['_id']) }}">Edit</a>
            <form method="POST" action="{{ route('notes.destroy', $note['_id']) }}" class="inline" onsubmit="return confirm('Delete this note?')">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    @empty
        <p>You have no notes yet.</p>
    @endforelse

    @include('partials.pagination')
@endsection
