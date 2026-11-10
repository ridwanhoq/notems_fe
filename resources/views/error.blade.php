@extends('layouts.main')

@section('title', 'Error')

@section('content')
    <div class="text-center py-5">
        <h1 class="display-5">{{ $status }}</h1>
        <p class="lead text-muted">{{ $message }}</p>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Go back</a>
    </div>
@endsection
