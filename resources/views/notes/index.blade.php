@extends('layouts.main')

@section('title', 'My Notes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">My Notes</h1>
        <a href="{{ route('notes.create') }}" class="btn btn-primary btn-sm">New note</a>
    </div>

    <div class="row g-3">
        @forelse ($data as $note)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('notes.show', $note['_id']) }}" class="text-decoration-none">{{ $note['title'] }}</a></h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($note['content'], 150) }}</p>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                        <small class="text-muted">{{ \Illuminate\Support\Carbon::parse($note['updatedAt'])->diffForHumans() }}</small>
                        <div>
                            <a href="{{ route('notes.edit', $note['_id']) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('notes.destroy', $note['_id']) }}" class="d-inline" onsubmit="return confirm('Delete this note?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12"><p class="text-muted">You have no notes yet.</p></div>
        @endforelse
    </div>

    @include('partials.pagination')
@endsection
