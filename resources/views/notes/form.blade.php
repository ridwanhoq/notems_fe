@extends('layouts.main')

@section('title', $note ? 'Edit Note' : 'New Note')

@section('content')
    <h1>{{ $note ? 'Edit Note' : 'New Note' }}</h1>
    <form method="POST" action="{{ $note ? route('notes.update', $note['_id']) : route('notes.store') }}">
        @csrf
        @if ($note)
            @method('PUT')
        @endif
        <label>Title <input type="text" name="title" value="{{ old('title', $note['title'] ?? '') }}" required maxlength="200"></label>
        <label>Content <textarea name="content">{{ old('content', $note['content'] ?? '') }}</textarea></label>
        <p>
            <button type="submit">Save</button>
            <a href="{{ route('notes.index') }}">Cancel</a>
        </p>
    </form>
@endsection
