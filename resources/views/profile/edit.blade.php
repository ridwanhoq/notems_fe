@extends('layouts.main')

@section('title', 'Profile')

@section('content')
    <h1>Profile</h1>
    <p class="muted">{{ $user['email'] }} &middot; {{ $user['role'] }}</p>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')
        <label>Name <input type="text" name="name" value="{{ old('name', $user['name']) }}" required></label>
        <label>Interests (comma separated)
            <input type="text" name="interests" value="{{ old('interests', implode(', ', $user['interests'] ?? [])) }}">
        </label>
        <label>New password (leave blank to keep) <input type="password" name="password" minlength="8"></label>
        <label>Confirm new password <input type="password" name="password_confirmation" minlength="8"></label>
        <p><button type="submit">Save</button></p>
    </form>
    <p><a href="{{ route('posts.user', $user['_id']) }}">View my posts</a></p>
@endsection
