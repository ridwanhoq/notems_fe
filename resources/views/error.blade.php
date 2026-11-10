@extends('layouts.main')

@section('title', 'Error')

@section('content')
    <h1>Error {{ $status }}</h1>
    <p>{{ $message }}</p>
    <a href="{{ url()->previous() }}">Go back</a>
@endsection
