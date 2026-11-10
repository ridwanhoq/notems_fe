@extends('layouts.main')

@section('title', 'Profile')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h1 class="h3 mb-0">Profile</h1>
                <a href="{{ route('posts.user', $user['_id']) }}" class="btn btn-outline-secondary btn-sm">My posts</a>
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-muted">{{ $user['email'] }} <span class="badge text-bg-secondary">{{ $user['role'] }}</span></p>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $user['name']) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="interests">Interests</label>
                            <input class="form-control" type="text" id="interests" name="interests" value="{{ old('interests', implode(', ', $user['interests'] ?? [])) }}">
                            <div class="form-text">Comma separated</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="password">New password</label>
                                <input class="form-control" type="password" id="password" name="password" minlength="8" placeholder="Leave blank to keep">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="form-label" for="password_confirmation">Confirm new password</label>
                                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" minlength="8">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
