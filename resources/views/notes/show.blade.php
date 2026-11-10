@extends('layouts.main')

@section('title', $note['title'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <h1 class="h3">{{ $note['title'] }}</h1>
                        @if ($note['user'] === session('api_user._id'))
                            <a href="{{ route('notes.edit', $note['_id']) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                        @endif
                    </div>
                    <p class="text-muted small">Created {{ \Illuminate\Support\Carbon::parse($note['createdAt'])->toDayDateTimeString() }}</p>
                    <div style="white-space: pre-wrap">{{ $note['content'] }}</div>
                </div>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-link px-0 mt-2">Back</a>
        </div>
    </div>
@endsection
