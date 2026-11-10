@extends('layouts.main')

@section('title', $user ? 'Edit User' : 'New User')

@section('content')
    <h1>{{ $user ? 'Edit User' : 'New User' }}</h1>
    <form method="POST" action="{{ $user ? route('users.update', $user['_id']) : route('users.store') }}">
        @csrf
        @if ($user)
            @method('PUT')
        @endif
        <label>Name <input type="text" name="name" value="{{ old('name', $user['name'] ?? '') }}" required></label>
        <label>Email <input type="email" name="email" value="{{ old('email', $user['email'] ?? '') }}" required></label>
        <label>Role
            <select name="role">
                @foreach (['user', 'admin'] as $role)
                    <option value="{{ $role }}" @selected(old('role', $user['role'] ?? 'user') === $role)>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        </label>
        <label>Interests (comma separated)
            <input type="text" name="interests" value="{{ old('interests', implode(', ', $user['interests'] ?? [])) }}">
        </label>
        <label>{{ $user ? 'New password (leave blank to keep)' : 'Password' }}
            <input type="password" name="password" minlength="8" @required(! $user)>
        </label>
        <p>
            <button type="submit">Save</button>
            <a href="{{ route('users.index') }}">Cancel</a>
        </p>
    </form>
@endsection
