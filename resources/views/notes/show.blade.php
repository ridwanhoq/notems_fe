@extends('layouts.main')

@section('title', $note['title'])

@section('content')
    <h1>{{ $note['title'] }}</h1>
    <p class="muted">Created {{ \Illuminate\Support\Carbon::parse($note['createdAt'])->toDayDateTimeString() }}</p>
    <div style="white-space: pre-wrap">{{ $note['content'] }}</div>
    @if ($note['user'] === session('api_user._id'))
        <p><a href="{{ route('notes.edit', $note['_id']) }}">Edit</a></p>
    @endif
@endsection
