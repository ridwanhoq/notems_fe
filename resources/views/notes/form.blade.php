@extends('layouts.main')

@section('title', $note ? 'Edit Note' : 'New Note')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="h3 mb-3">{{ $note ? 'Edit Note' : 'New Note' }}</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ $note ? route('notes.update', $note['_id']) : route('notes.store') }}">
                        @csrf
                        @if ($note)
                            @method('PUT')
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="title">Title</label>
                            <input class="form-control" type="text" id="title" name="title" value="{{ old('title', $note['title'] ?? '') }}" required maxlength="200">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" rows="8">{{ old('content', $note['content'] ?? '') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('notes.index') }}" class="btn btn-link">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
