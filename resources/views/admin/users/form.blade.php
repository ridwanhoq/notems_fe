@extends('layouts.main')

@section('title', $user ? 'Edit User' : 'New User')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <h1 class="h3 mb-3">{{ $user ? 'Edit User' : 'New User' }}</h1>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST" action="{{ $user ? route('users.update', $user['_id']) : route('users.store') }}">
                        @csrf
                        @if ($user)
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $user['name'] ?? '') }}" required>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user['email'] ?? '') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="role">Role</label>
                                <select class="form-select" id="role" name="role">
                                    @foreach (['user', 'admin'] as $role)
                                        <option value="{{ $role }}" @selected(old('role', $user['role'] ?? 'user') === $role)>{{ ucfirst($role) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="password">{{ $user ? 'New password' : 'Password' }}</label>
                                <input class="form-control" type="password" id="password" name="password" minlength="8" @required(! $user) @if ($user) placeholder="Leave blank to keep" @endif>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="interests">Interests</label>
                            <input class="form-control" type="text" id="interests" name="interests" value="{{ old('interests', implode(', ', $user['interests'] ?? [])) }}">
                            <div class="form-text">Comma separated</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <a href="{{ route('users.index') }}" class="btn btn-link">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
